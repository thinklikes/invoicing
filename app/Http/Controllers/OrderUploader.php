<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Platform;
use App\Services\OrderUploaderService as Service;
use App\Http\Requests\OrderUploaderRequest as ORequest;

class OrderUploader extends Controller
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $platforms = Platform::where('isDisabled', 0)->get();
        return view('erp.sale.orderUploader.index', [
            'platforms' => $platforms,
        ]);
    }

    //讀取上傳的EXCEL檔案
    public function save(ORequest $request)
    {
        $file = $request->file('orderUploader.upload_file');
        //確認檔案是有效的
        if ($file->isValid()) {
            $platform_name = $request->input('orderUploader.platform_name');

            //設定上傳的平台
            $this->service->setPlatformName($platform_name);
            $status = $this->service->loadAndSaveB2CExcel($file);

            return redirect()->route('orderUploader::index')->with(['status' => $status]);
        } else {
            $errors = new MessageBag(['檔案上傳失敗!!']);
            return back()->withErrors($errors);
        }
    }
}
