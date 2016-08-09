<?php

namespace App\Http\Controllers\Basic;

use Option\OptionRepository;
use App\Http\Controllers\Controller;
use App\Contracts\FormRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\BasicController;
use Excel;
use Carbon\Carbon;
use App;

class SystemConfigController extends BasicController
{
    private $routeName = 'erp.basic.system_config';

    public function __construct()
    {
        $this->setFullClassName();
    }
    /**
     * 本控制器的index方法
     * @return page
     */
    public function index()
    {
        return view($this->routeName.'.index', [
            'configs' => OptionRepository::getAllConfigs()
        ]);
    }
    // /**
    //  * 本控制器的edit方法
    //  * @return page
    //  */
    public function edit()
    {
        //$EditRoute = route('SystemConfigsEditor');
        return view($this->routeName.'.edit', [
            'configs' => OptionRepository::getAllConfigs()
        ]);
    }
    // /**
    //  * 本控制器的update方法
    //  * 執行前會先給ErpRequest驗證
    //  * 若驗證有誤則導回前頁
    //  * 異動完後導回/system_configs
    //  * @return page
    //  */
    public function update(FormRequestInterface $request)
    {
        OptionRepository::setSystemConfigs($request->input('configs'));

        return redirect()->action(
                "$this->className@index")
            ->with(['status' => new MessageBag(['系統參數已更新'])]);
    }

    public function updateLogs($page = 0)
    {
        //顯示git更新記錄
        if (!$page) {
            $page = 0;
        }
        $skip = 10 * $page;

        exec('git log -10 --skip='.$skip.' --format=%cd%s --date=iso --grep="\[visiable\]"'
            , $git_logs);
        //exec('whoami', $output);
        return view("$this->routeName.updateLogs", ['logs' => $git_logs]);
    }

    public function exportSettings()
    {
        return view($this->routeName.'.exportSettings');
    }

    public function export(Request $request)
    {
        if ($request->input('data_type') == 'sql') {
            return $this->saveAndExportSqlFile();

        } else {

        }
    }


    public function importSettings()
    {
        return view($this->routeName.'.importSettings');
    }

    public function generataImportDemo()
    {
        $excel = Excel::create('importDemo', function ($excel) {

            // Set the title
            $excel->setTitle('Import Demo');

            // Chain the setters
            $excel->setCreator('Alfie Kuo');
                  //->setCompany(iconv('utf-8', 'Big5', '傑瑀企業有限公司'));

            // Call them separately
            $excel->setDescription('demo table of Data to import');

            $excel->sheet('sheetName', function ($sheet) {
                // Set top, right, bottom, left
                // $sheet->setPageMargin(array(
                //     0.25, 0.30, 0.25, 0.30
                // ));
                // $sheet->with([
                //     array('data1', 'data2'),
                //     array('data3', 'data4'),
                //     array('data5', 'data6')
                // ], null, 'A1', true);
                $a = App::make('Company\Company')->get();
                $sheet->fromModel($a , null, 'A1', true);
            });
            $excel->sheet('sheetName2', function ($sheet) {
                // Set all margins
                $sheet->setPageMargin(0.25);
            });
        })
        ->store('xls');

        //return $excel;
    }

    private function saveAndExportSqlFile()
    {
        $db = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');
        $path = storage_path('exports');
        $filename = $db.'_'.(Carbon::now()->format('Ymd_His')).'.sql';
        // //儲存SQL檔案
        $str = exec('mysqldump -u'.$db_user.' -p'.$db_password.' '.$db.' > '.$path.'/'.$filename);
        // //開始下載
        return response()->download($path.'/'.$filename);
    }
}
