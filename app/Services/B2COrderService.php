<?php

namespace App\Services;

use DB;
use App;
use App\SaleOrderMaster;
use App\SaleOrderDetail;
use Exception;

class B2COrderService
{
    private $master;
    private $detail;
    private $platform;

    public function __construct(
        SaleOrderMaster $master,
        SaleOrderDetail $detail
    ) {
        $this->master = $master;
        $this->detail = $detail;
    }

    public function setPlatformName($platform_name) {
        $this->platform = $platform_name;
    }

    public function getOrderList()
    {
        return $this->master->select('upload_time', DB::raw('count(*) as count'))
            ->where('platform', $this->platform)
            ->groupBy('upload_time')
            ->orderBy('upload_time', 'desc')
            ->get();
    }

    public function getPaywayList()
    {
        return $this->master->select(DB::raw('distinct payway'))
            ->where('platform', $this->platform)
            ->get()
            ->pluck('payway');
    }

    public function getOrdersByUpdateTime($upload_time, $search = array())
    {
        $defaultConditions = [];
        $defaultConditions[] = ['platform', '=', $this->platform];
        $defaultConditions[] = ['upload_time', '=', $upload_time];


        $conditions = [];
        $itemConditions = [];

        $builder = $this->master->with('detail')->where($defaultConditions);

        if (isset($search['platform_code']) && $search['platform_code'] != "") {
            $builder->where('platform_code', '=', $search['platform_code']);
        }
        if (isset($search['customer_name']) && $search['customer_name'] != "") {
            $builder->where('customer_name', 'like', '%'.$search['customer_name'].'%');
        }
        if (isset($search['customer_tel']) && $search['customer_tel'] != "") {
            $builder->where('customer_tel', 'like', '%'.$search['customer_tel'].'%');
        }
        if (isset($search['recipient']) && $search['recipient'] != "") {
            $builder->where('recipient', 'like', '%'.$search['recipient'].'%');
        }
        if (isset($search['recipient_tel']) && $search['recipient_tel'] != "") {
            $builder->where('recipient_tel', 'like', '%'.$search['recipient_tel'].'%');
        }
        if (isset($search['pay_status']) && $search['pay_status'] != "") {
            $builder->where('pay_status', '=', $search['pay_status']);
        }
        if (isset($search['payway']) && $search['payway'] != "") {
            $builder->where('payway', '=', $search['payway']);
        }
        if (isset($search['delivery_method']) && $search['delivery_method'] != "") {
            $builder->where('delivery_method', 'like', '%'.$search['delivery_method'].'%');
        }
        if (isset($search['isRepeated']) && $search['isRepeated']) {
            // 暫時disabled ONLY_FULL_GROUP_BY
            DB::statement("SET sql_mode='';");

            // 找出重複購買的購買人名稱與手機
            // 購買人姓名有時候會有()備註
            // group by 的時候將他濾掉
            $repeated['customer'] = $this->master->select(
                    DB::raw('SUBSTRING_INDEX(customer_name, "(", 1) as customer_name'),
                    'customer_tel'
                )
                ->where($defaultConditions)
                ->groupBy(DB::raw('SUBSTRING_INDEX(customer_name, "(", 1)'), 'customer_tel')
                ->havingRaw('count(1) > 1')
                ->get()
                ->map(function ($item, $key) {
                    return collect([
                        ['customer_name', $item->customer_name],
                        ['customer_tel', $item->customer_tel],
                    ]);
                })
                ->toArray();

            $repeated['recipient'] = $this->master->select('recipient_tel')
                ->where($defaultConditions)
                ->groupBy('recipient_tel')
                ->havingRaw('count(1) > 1')
                ->get()
                ->toArray();

            $codes = [];

            foreach ($repeated as $someone => $info) {

                if (count($info) > 0) {
                    // 找出重複的訂單id
                    $repeatBuilder = $this->master->select('code')->where($defaultConditions);

                    $repeatBuilder->where(function ($query) use ($info) {
                        foreach ($info as $columns) {
                            $query->orWhere($columns);
                        }
                    });

//                    foreach ($repeated as $columns) {
//                        $repeatBuilder->where(function ($query) use ($columns) {
//                            foreach($columns as $column => $value) {
//                                $query->orWhere($column, $value);
//                            }
//                        });
//                    }
                    $codes = $codes + $repeatBuilder->get()->toArray();
                }
            }

            $builder->whereIn('code', $codes);
        }

        if (isset($search['item']) && $search['item']) {
            $codes = $this->detail->select('master_code')
                ->where([['item', 'like', '%'.$search['item'].'%']])
                ->groupBy('master_code')
                ->get()->toArray();

            $builder->whereIn('code', $codes);
        }

        if (isset($search['island']) && $search['island']) {
            $builder->where(function ($query) {
                $query->orWhere('city', 'like', '%金門%');
                $query->orWhere('address', 'like', '%金門%');
                $query->orWhere('city', 'like', '%連江%');
                $query->orWhere('address', 'like', '%金門%');
                $query->orWhere('city', 'like', '%澎湖%');
                $query->orWhere('address', 'like', '%澎湖%');
                $query->orWhere('city', 'like', '%綠島%');
                $query->orWhere('address', 'like', '%綠島%');
                $query->orWhere('city', 'like', '%蘭嶼%');
                $query->orWhere('address', 'like', '%蘭嶼%');
                $query->orWhere('city', 'like', '%馬祖%');
                $query->orWhere('address', 'like', '%馬祖%');
            });
        }

        if (isset($search['isCool']) && $search['isCool']) {
            $builder->where('isCool', 1);
        }
        //分頁
        $orders = $builder->paginate(20);
        $default_path = $this->platform.'?upload_time='.$upload_time;
        if (count($search) > 0) {
            foreach ($search as $column => $value) {
                $default_path .= "&search[".$column."]=".$value;
            }
        }
        $orders->setPath($default_path);

        return $orders;
    }

    public function getOrderCountsByUpdateTime($upload_time)
    {
        $defaultConditions = [];
        $defaultConditions[] = ['platform', '=', $this->platform];
        $defaultConditions[] = ['upload_time', '=', $upload_time];

        $orders = $this->master->with('detail')->where($defaultConditions)->get();

        return [
            // 訂單總數
            'total' => $orders->count(),
            //訂單總金額
            'total_amount' => $orders->sum(function ($master) {
                return $master->detail->sum(function ($detail) {
                    return $detail->quantity * $detail->price;
                });
            }),
            // 未付款訂單數
            'not_payed' => $orders->where('pay_status', '未付款')->count(),
            // 未付款總額
            'not_payed_amount' => $orders->where('pay_status', '未付款')->sum(function ($master) {
                return $master->detail->sum(function ($detail) {
                    return $detail->quantity * $detail->price;
                });
            }),
            // 已付款訂單數
            'payed' => $orders->where('pay_status', '已付款')->count(),
            // 已付款總金額
            'payed_amount' => $orders->where('pay_status', '已付款')->sum(function ($master) {
                return $master->detail->sum(function ($detail) {
                    return $detail->quantity * $detail->price;
                });
            }),
            // 黑貓訂單數
            'blackCat' => $orders->filter(function ($item) {
                return strpos($item['delivery_method'], '黑貓') !== false;
            })->count(),

            // 超商訂單數
            'superMarket' => $orders->filter(function ($item) {
                return strpos($item['delivery_method'], '超商') !== false;
            })->count(),
        ];
    }

    public function updateOrderById($id, $order)
    {
        $status = true;
        $master = $this->master->find($id);
        $status = $status && $master->fill($order['master'])->save();

        $this->detail
            ->where('master_code', $master->code)
            ->delete();

        foreach ($order['detail'] as $value) {
            $detail = $this->detail->newInstance()->fill($value);
            $detail->master_code = $master->code;

            $status = $status && $detail->save();
        }
        return $status ? ['status' => '更新訂單'.$master->platform_code.'成功'] : false;
    }

    public function deleteOrderById($id)
    {
        $model = $this->master->where('id', $id)->first();

        $platform_code = $model->platform_code;

        return $model->delete() ? ['status' => '刪除訂單'.$platform_code.'成功'] : false;
    }

    public function deleteOrdersByUploadTime($upload_time, $platform)
    {
        return $this->master->where('upload_time', $upload_time)->where('platform', $platform)->delete()
            ? ['status' => '刪除訂單成功'] : false;
    }

    public function getDetailAmountByUpdateTime($upload_time)
    {
        $masters = $this->master
            ->where('upload_time', $upload_time)
            ->get();

        $codes = $masters->pluck('code')->all();

        $details = $this->detail->select('item', DB::raw('SUM(quantity) as sum'))
            ->whereIn('master_code', $codes)
            ->groupBy('item')
            ->get();

        //dd($details);
        return $details;
    }

    public function getBlackCatDataByUpdateTime($upload_time, $isCool)
    {
        $masters = $this->master->with('detail')
            ->where('upload_time', $upload_time)
            ->where('delivery_method', 'like', '宅配%')
            ->where('isCool', $isCool)
            ->where('platform', $this->platform)
            ->get();

        $data = collect([]);

        foreach ($masters as $key => $master) {
            try {
                if (!$master->delivery_date) {
                    throw new \Exception;
                }
                // 處理希望送達日期
                $delivery_date = $master->delivery_date->format('Y') > 0
                    ? $master->delivery_date->format('Ymd')
                    : '';
            } catch (\Exception $e) {
                $delivery_date = '';
            }


            // 處理內容物
            $item = '';

            // 總金額
            $total = 0;
            foreach ($master->detail as $detail) {
                $total += $detail->quantity * $detail->price;
                // 內容物不顯示運費或活動折扣總計
                if ($detail->item == '運費' || $detail->item == '活動折扣總計') {
                    continue;
                }
                $item .= $detail->item." x ".$detail->quantity." ";
            }

            $data[$key] = collect([
                $master->recipient,
                $master->recipient_tel,
                '',
                $master->city.$master->address,
                $delivery_date,
                $master->delivery_time,
                $item,
                ($master->pay_status == '未付款') ? $total : '',
                $master->note,
                '',
                '',
            ]);
        }

        return $data;
    }
    public function getSuperMarketDataByUpdateTime($upload_time)
    {
        $masters = $this->master->with('detail')
            ->where('upload_time', $upload_time)
            ->where('delivery_method', 'like', '超商%')
            ->where('platform', $this->platform)
            ->get();

        $data = collect([]);

        foreach ($masters as $key => $master) {
            try {
                if (!$master->delivery_date) {
                    throw new \Exception;
                }
                // 處理希望送達日期
                $delivery_date = $master->delivery_date->format('Y') > 0
                    ? $master->delivery_date->format('Ymd')
                    : '';
            } catch (\Exception $e) {
                $delivery_date = '';
            }


            // 處理內容物
            $item = '';

            // 總金額
            $total = 0;
            foreach ($master->detail as $detail) {
                $total += $detail->quantity * $detail->price;
                // 內容物不顯示運費或活動折扣總計
                if ($detail->item == '運費' || $detail->item == '活動折扣總計') {
                    continue;
                }
                $item .= $detail->item." x ".$detail->quantity." ";
            }

            $data[$key] = collect([
                $master->recipient,
                $master->recipient_tel,
                '',
                $master->city.$master->address,
                $delivery_date,
                $master->delivery_time,
                $item,
                ($master->pay_status == '未付款') ? $total : '',
                $master->note,
                '',
                '',
            ]);
        }

        return $data;
    }
}