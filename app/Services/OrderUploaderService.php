<?php

namespace App\Services;

use App;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use App\Services\B2CLogicInterface;
use App\SaleOrderMaster;
use App\SaleOrderDetail;
use Storage;

// Excel 讀取器
use App\Services\ExcelDataReaderFor91APP;
use App\Services\ExcelDataReaderForQDM;

class OrderUploaderService
{
    private $path;
    private $logic;
    private $platform_name;
    private $master;

    public function __construct(
        SaleOrderMaster $master,
        SaleOrderDetail $detail
    ) {
        $this->path = storage_path('app/public');
        $this->master = $master;
        $this->detail = $detail;
    }

    public function setPlatformName($platform_name)
    {
        $this->platform_name = $platform_name;
        switch ($platform_name) {
            case 'QDM':
            case 'QDM2':
                $this->logic = App::make('App\Services\ExcelDataReaderForQDM', [
                    'platform' => $platform_name,
                ]);
                break;
            case '91APP':
                $this->logic = App::make('App\Services\ExcelDataReaderFor91APP');
                break;
            case 'yahoo':
                $this->logic = App::make('App\Services\ExcelDataReaderForYahoo');
                break;
            case 'YAHOO超商':
                $this->logic = App::make('App\Services\ExcelDataReaderForYahooSM');
                break;
            case '姐妹購物網':
            case '好吃宅配網':
            case '生活市集':
                $this->logic = App::make('App\Services\ExcelDataReaderForLifeSM', [
                    'platform' => $platform_name,
                ]);
                break;
            case '東森':
            case '森森':
                $this->logic = App::make('App\Services\ExcelDataReaderForUMall', [
                    'platform' => $platform_name,
                ]);
                break;
            case '夠麻吉':
                $this->logic = App::make('App\Services\ExcelDataReaderForGOMAJI');
                break;
            case '樂天':
                $this->logic = App::make('App\Services\ExcelDataReaderForRakuten');
                break;
            default:
                # code...
                break;
        }
    }

    // public function getB2CExceltypes() {
    //     return $this->logic->getTypes();
    // }

    // 將傳入的EXCEL內容讀取出來
    public function loadAndSaveB2CExcel($file)
    {
        $filename = $this->moveFile($file);

        $data = $this->logic->loadData($this->path . '/' . $filename);
        // 找出最大單號
        $code = SaleOrderMaster::where('code', 'like', date('Ymd') . '%')->max('code');

        $platform_codes = $this->master->select('platform_code')
            ->where('platform', $this->platform_name)
            ->get()
            ->pluck('platform_code');

        if (!$code) {
            $code = date('Ymd') . '0001';
        } else {
            $code = $code + 1;
        }

        $hasAdded = 0;
        foreach ($data as $key => $row) {
//            if ($platform_codes->contains($row['saleOrderMaster']['platform_code'])) {
//                continue;
//            }
            $master = new \App\SaleOrderMaster;

            $data = $row['saleOrderMaster']->toArray();
            try {
                $data['date_of_buying'] = Carbon::createFromFormat('Y/m/d H:i', $data['date_of_buying']);
            } catch (\Exception $e) {

            }

            $master->fill($data);
            $master->code = $code;
            $master->save();

            foreach ($row['saleOrderDetail'] as $key2 => $item) {
                $detail = new \App\SaleOrderDetail;
                $detail->fill($item->toArray());
                $detail->master_code = $code;
                $detail->save();
            }

            $code ++;
            $hasAdded ++;
        }

        return $hasAdded > 0 ? ['上傳成功'] : ['本次上傳的訂單已存在, 沒有上傳'];
    }

    private function moveFile($file)
    {
        //上傳檔案的原始檔名
        $filename = $file->getClientOriginalName();

        //將上傳的檔案移動到存放的目錄
        $file->move($this->path, $filename);

        if ($file->getClientOriginalExtension() == 'csv') {
            try {
                $contents = Storage::get('public/'.$filename);
                $contents = iconv('BIG5', 'UTF-8', $contents);
                Storage::put('public/'.$filename, $contents);
            } catch (\Exception $e) {

            }
        }

        return $filename;
    }
}