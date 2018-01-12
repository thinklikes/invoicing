<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Contracts\B2CExcelDataReader;
use Excel;
use Carbon\Carbon;
use Storage;

class ExcelDataReaderForLifeSM implements B2CExcelDataReader
{
    private $platform = '';

    private $upload_time = '';

    private $primary = '';

    //需要轉換成字串的欄位
    private $toString = [];

    //需要轉換成日期的欄位
    private $toDate = [];

    // 用來做資料表欄位對應的陣列
    private $columnsMapping = [
        'head' => [
            'saleOrderMaster' => [
                // 'code' => "客戶訂單號",
                // 'platform' => "平台名稱",
                'platform_code' => '訂單編號',
                // 'upload_time' => "excel上傳時間",
                'date_of_buying' => "出貨確認日",
                'customer_name' => "收件人",
                'customer_tel' => "電話",
//                'customer_email' => "電子郵件",
//                'pay_status' => "付款狀態",
                'recipient' => "收件人",
                'recipient_tel' => "電話",
//                'city' => "縣市",
//                'zip' => "郵遞區號",
                'address' => "收件地址",
                'payway' => "付款別",
//                'transfer_time' => "匯款時間",
//                'transfer_code' => "匯款後5碼",
//                'bank' => "匯款銀行",
                'delivery_method' => "超商類型",
//                'delivery_date' => "建議貨到期限",
//                'delivery_time' => "希望送達時段",
//                'words_to_boss' => "給店長的話",
//                'taxNumber' => "統一編號",
//                'InvoiceName' => "發票抬頭",
//                'note' => '購物車備註',
                //'isCool' => '溫層類別'
               'note' => '備註購買人資料',//不知道為什麼括號會被拿掉
            ],
            'others' => [
//                'FEE' => '運費',
//                'DISCOUNT' => '折扣金額',
            ],
        ],
        'body' => [
            'saleOrderDetail' => [
                'item' => '訂購方案',
                //'price' => '商品單價',
                'quantity' => '組數',
            ],
        ],
    ];

    private $time_ranges = [
        1 => '中午前',
        2 => '下午：12：00 ~ 17：00',
        3 => '晚上：17時 - 20時',
    ];

    private $itemMappingFileName = 'ItemMapping.txt';

    private $itemNameMapping = [];

    public function __construct($platform)
    {
        $this->platform = $platform;

        $this->primary = $this->columnsMapping['head']['saleOrderMaster']['platform_code'];

        $this->toString = [
            $this->columnsMapping['head']['saleOrderMaster']['platform_code'],
        ];

        $this->toDate = [
            $this->columnsMapping['head']['saleOrderMaster']['date_of_buying'],
        ];

        // 取出品名對應表
        try{
            $contents = json_decode(Storage::get($this->itemMappingFileName));

            foreach($contents->{$this->platform} as $item) {
                $this->itemNameMapping[$item[0]] = $item[1];
            }
        } catch (\Exception $e) {

        }

        $this->upload_time = date('Y-m-d H:i:s');
    }


    /** 轉化excel的欄位為table使用的欄位
     * @param array $dataRow
     * @return array
     */
    protected function transformate(Collection $item)
    {
        $columnsMapping = $this->columnsMapping;
        $returnData = clone $item;

        // 先過濾表頭資訊, 表頭資訊都會在第一列
        foreach ($columnsMapping['head'] as $table => $columns) {
            // $table 資料表名稱
            // $columns 資料表欄位
            $returnData[$table] = collect([]);
            foreach ($columns as $column => $title) {
                if (!isset($item[0][$title])) {
                    continue;
                }

                // 處理希望送達時段
                if (
                    isset($this->columnsMapping['head']['saleOrderMaster']['delivery_time'])
                    && $title == $this->columnsMapping['head']['saleOrderMaster']['delivery_time']
                ) {
                    $returnData[$table][$column] = $this->getDeliveryTime($item[0][$title]);
                    continue;
                }


                $returnData[$table][$column] = trim($item[0][$title]);
            }

        }

        // 當信用卡付款時, 設定為已付款
//        if (
//            isset($this->columnsMapping['head']['saleOrderMaster']['payway'])
//            && strpos($returnData['saleOrderMaster']['payway'], '信用卡') !== false
//        ) {
//            $returnData['saleOrderMaster']['pay_status'] = '已付款';
//        }
        $returnData['saleOrderMaster']['platform'] = $this->platform;
        $returnData['saleOrderMaster']['upload_time'] = $this->upload_time;
        $returnData['saleOrderMaster']['pay_status'] = '已付款';
        // 電話左側補0
        $returnData['saleOrderMaster']['customer_tel'] = '0'.$returnData['saleOrderMaster']['customer_tel'];
        $returnData['saleOrderMaster']['recipient_tel'] = '0'.$returnData['saleOrderMaster']['recipient_tel'];

        try {
            // 設定配送方式不是超商就是宅配
            $returnData['saleOrderMaster']['delivery_method']
                = strpos($returnData['saleOrderMaster']['delivery_method'], '超商') !== false
                ? '超商'
                : '宅配';
        } catch (\Exception $e) {
            $returnData['saleOrderMaster']['delivery_method'] = '宅配';
        }

        foreach ($columnsMapping['body'] as $table => $columns) {
            $process = collect([]);
            foreach ($item as $index => $row) {
                $process[$index] = collect([]);
                foreach ($columns as $column => $key) {
                    // 將品名替換成系統用的品名
                    if (
                        isset($this->columnsMapping['body']['saleOrderDetail']['item'])
                        && $key == $this->columnsMapping['body']['saleOrderDetail']['item']
                    ) {

                        $item_name = trim($item[0]['檔次名稱']);
                        $item_name .= trim($item[0][$key]);
                        // 品名中有酸梅湯的標示為冷藏件
                        if (strpos($row[$key], '酸梅湯') !== false) {
                            $returnData['saleOrderMaster']['isCool'] = 1;
                        }
                        if(isset($this->itemNameMapping[$item_name])) {
                            $process[$index][$column] = $this->itemNameMapping[$item_name];
                        } else {
                            $process[$index][$column] = $item_name;
                        }
                        continue;
                    }
                    $process[$index][$column] = $row[$key];
                }
            };
            // 將$process 的內容複製到$returnData[$table]
            $returnData[$table] = clone $process;
        }

        // 運費項目處理
        if (isset($returnData['others']['FEE']) && $returnData['others']['FEE'] > 0) {
            $returnData['saleOrderDetail']->push(collect([
                'item' => $this->columnsMapping['head']['others']['FEE'],
                'quantity' => 1,
                'price' => $returnData['others']['FEE'],
            ]));
        }

        // 活動折扣處理
        if (isset($returnData['others']['DISCOUNT']) && $returnData['others']['DISCOUNT'] > 0) {
            $returnData['saleOrderDetail']->push(collect([
                'item' => $this->columnsMapping['head']['others']['DISCOUNT'],
                'quantity' => -1,
                'price' => $returnData['others']['DISCOUNT'],
            ]));
        }

        unset($returnData['others']);

        return $returnData;
    }

    protected function convertColumns(Collection $item)
    {
        return $item->map(function ($row) {
            // 將訂單內容轉為字串
            foreach ($this->toString as $key) {
                $key = strtolower($key);
                $row[$key] = (string) $row[$key];
            }

            // 將訂單內容轉為日期
            foreach ($this->toDate as $key) {
                try {
                    $row[$key] = Carbon::createFromFormat('Y-m-d H:i:s', $row[$key]);
                } catch (\Exception $e) {

                }
            }
            return $row;
        });
    }

    public function loadData($filename) {
        try {
            $data = Excel::load($filename)->get();
        } catch (\Exception $e) {
            dd('檔案格式有錯誤!!請重新下載上傳!!或聯絡電商平台!!1');
        }

//        try {
        $data = $this->convertColumns($data);
//        } catch (\Exception $e2) {
//            dd($e2->getMessage());
//            dd('檔案格式有錯誤!!請重新下載上傳!!或聯絡電商平台!!2');
//        }

        //將訂單用訂單編號分組
        $data = $data->groupBy($this->primary);

        // 標註各項狀態
        $data = $data->map(function ($item) {
            // 轉化excel的欄位為table使用的欄位
            $item = $this->transformate($item);
            return $item;
        });

        return $data;
    }

    private function getDeliveryTime($time) {
        // 處理希望送達時間
        try {
            $delivery_time = '';

            foreach ($this->time_ranges as $key => $time_range) {
                if (strpos($time, $time_range) !== false) {
                    $delivery_time = $key;
                    break;
                }
            }

            if ($delivery_time == '' && strpos($time, '任何時段皆可') === false) {
                throw new \Exception("Error Processing Request", 1);
            }
        } catch (\Exception $e) {
            // 找不到時段而且也不是任何時段皆可
            $delivery_time = $time;
        }

        return $delivery_time;
    }
}