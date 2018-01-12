<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\B2COrderService;

use MessageBag;

use Excel;

use App\Platform;

class B2COrderController extends Controller
{
    private $service;

    public function __construct(B2COrderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $platforms = Platform::where('isDisabled', 0)->get();
        return view('erp.sale.b2cOrder.index', [
            'platforms' => $platforms
        ]);
    }

    public function subIndex($platform)
    {
        $this->service->setPlatformName($platform);
        $data = $this->service->getOrderList();

        return view('erp.sale.b2cOrder.subIndex', [
            'platform' => $platform,
            'data' => $data,
            'i' => 0
        ]);
    }

    public function detail($platform, Request $request)
    {
        $upload_time = $request->input('upload_time');

        $search = $request->input('search');

        $page = $request->input('page');

        $this->service->setPlatformName($platform);

        $data = $this->service->getOrdersByUpdateTime($upload_time, $search);

        $counts = $this->service->getOrderCountsByUpdateTime($upload_time);

        return view('erp.sale.b2cOrder.detail2', [
            'platform' => $platform,
            'upload_time' => $upload_time,
            'data' => $data,
            'counts' => $counts,
            'search' => $search,
            'payways' => $this->service->getPaywayList(),
            'count' => 0,
            'page' => $page,
            'id' => $request->input('id')
        ]);
    }

    public function update($platform, $id, Request $request)
    {
        $order = $request->input('order');
        $upload_time = $request->input('upload_time');
        $page = $request->input('page');

        $status = $this->service->updateOrderById($id, $order);

        if ($status) {
            return redirect()->action('B2COrderController@detail', [
                'platform' => $platform,
                'upload_time' => $upload_time,
                'id' => $id,
                'page' => $page,
                'search' => $request->input('search'),
            ])
            ->with(['status' => $status]);
        } else {
            return back()->withInput()->withErrors(new MessageBag(['訂單刪除失敗!']));
        }
    }

    public function delete($platform, $id, Request $request)
    {
        $upload_time = $request->input('upload_time');

        $status = $this->service->deleteOrderById($id);

        if ($status) {
            return redirect()->action('B2COrderController@detail', [
                'platform' => $platform,
                'upload_time' => $upload_time
            ])
            ->with(['status' => $status]);
        } else {
            return back()->withInput()->withErrors(new MessageBag(['訂單刪除失敗!']));
        }
    }

    public function deleteOrders($platform, Request $request)
    {
        $upload_time = $request->input('upload_time');

        $status = $this->service->deleteOrdersByUploadTime($upload_time, $platform);

        if ($status) {
            return redirect()->action('B2COrderController@subIndex', [
                'platform' => $platform,
            ])->with(['status' => $status]);
        } else {
            return back()->withInput()->withErrors(new MessageBag(['訂單刪除失敗!']));
        }
    }

    public function export($platform, Request $request)
    {
        $this->service->setPlatformName($platform);
        $upload_time = $request->input('upload_time');

        $data = $this->service->getDetailAmountByUpdateTime($upload_time);

        return Excel::create($platform.'_'.$upload_time, function($excel) use ($data) {

            $excel->sheet('new sheet', function($sheet) use ($data) {

                $i = 1;
                $sheet->row($i, [
                    '訂購商品', '數量'
                ]);
                ++ $i;
                foreach ($data->toArray() as $value) {
                    $sheet->row($i, $value);
                    ++ $i;
                }
            });

        })->export('xls');

    }

    public function exportBlackCat($platform, Request $request)
    {
        $this->service->setPlatformName($platform);

        $upload_time = $request->input('upload_time');

        $isCool = $request->input('isCool');

        $data = $this->service->getBlackCatDataByUpdateTime($upload_time, $isCool);

        $filename = '黑貓'.$platform.'_'.$upload_time.'_'.($isCool == 1 ?  '冷藏' : '一般');

        return Excel::create($filename, function($excel) use ($data) {

            $excel->sheet('new sheet', function($sheet) use ($data) {

                //$sheet->setOrientation('landscape');
                //$sheet->with($data);
                $i = 1;
                $sheet->row($i, [
                    '姓名',
                    '電話',
                    '縣市',
                    '地址',
                    '希望送達日',
                    '指定時段',
                    '內容物',
                    '代收款',
                    '備註',
                    '商品別',
                    '件數',
                ]);
                ++ $i;
                foreach ($data->toArray() as $value) {
                    $sheet->row($i, $value);
                    ++ $i;
                }
            });

        })->export('xls');

    }

    public function exportSuperMarket($platform, Request $request)
    {
        $this->service->setPlatformName($platform);

        $upload_time = $request->input('upload_time');

        $data = $this->service->getSuperMarketDataByUpdateTime($upload_time);

        $filename = '超商'.$platform.'_'.$upload_time;

        return Excel::create($filename, function($excel) use ($data) {

            $excel->sheet('new sheet', function($sheet) use ($data) {

                //$sheet->setOrientation('landscape');
                //$sheet->with($data);
                $i = 1;
                $sheet->row($i, [
                    '姓名',
                    '電話',
                    '縣市',
                    '地址',
                    '希望送達日',
                    '指定時段',
                    '內容物',
                    '代收款',
                    '備註',
                    '商品別',
                    '件數',
                ]);
                ++ $i;
                foreach ($data->toArray() as $value) {
                    $sheet->row($i, $value);
                    ++ $i;
                }
            });

        })->export('xls');

    }
}
