<?php

namespace App\Http\Controllers\Basic;

use App;
use Excel;
use Carbon\Carbon;
use Storage;
use Option\OptionRepository;
use App\Http\Controllers\Controller;
use App\Contracts\FormRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\BasicController;


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

    /**
     * 設定匯出選項的介面
     * @return Response 匯出介面
     */
    public function exportSettings()
    {
        return view($this->routeName.'.exportSettings');
    }

    /**
     * 開始匯出
     * @param  Request $request 表單請求的物件
     * @return Response           開始下載的回應
     */
    public function export(Request $request)
    {
        if ($request->input('data_type') == 'sql') {
            return $this->saveAndExportSqlFile();
        } else {

        }
    }

    /**
     * 設定匯入選項的介面
     * @return Response 帶有主機中備份存檔的選項之回應
     */
    public function importSettings()
    {
        //找出之前匯出過的檔案
        $files = Storage::files('exports');

        $tmp = array();

        foreach ($files as $file) {
            if (preg_match('/\.sql$/', $file)) {
                preg_match('/[\d]{8}_[\d]{6}/', $file, $matches);
                $key = Carbon::createFromFormat('Ymd_His', $matches[0])->format('Y年m月d日 H時i分s秒');

                $tmp[$key] = explode("/", $file)[1];
            }
        }

        $files = $tmp;
        //var_dump(glob(storage_path('exports').'/*'));
        return view($this->routeName.'.importSettings', [
            'files' => $files
        ]);
    }

    /**
     * 開始匯入
     * @param  Request $request 表單請求的物件
     * @return Response           開始匯入處理的回應
     */
    public function import(Request $request)
    {
        if ($request->input('file') == 'from_file') {
            if ($request->file('upload_file')->isValid()) {
                //如果上傳檔案是有效的
                //上傳檔案的原始檔名
                $filename = $request->file('upload_file')->getClientOriginalName();
                //上傳檔案的位置
                $path = storage_path('app/imports');
                //將上船的檔案移動到存放的目錄
                $request->file('upload_file')->move($path, $filename);
                //$realPath = $path.'/'.$filename;
            } else {
                $errors = new MessageBag(['檔案上傳失敗!!']);
                return back()->withErrors($errors);
            }
        } else if($request->input('file') != '') {
            $filename = $request->input('file');
            $path = storage_path('app/exports');
            //$realPath = $path.'/'.$filename;
        } else {
            //如果沒有選檔案，回上一頁並顯示錯誤
            $errors = new MessageBag(['您未選擇任何檔案!!']);
            return back()->withErrors($errors);
        }

        return $this->importSqlFileToMysql($path, $filename);

    }

    /**
     * 在主機上存檔後匯出
     * @param  string $realPath 存檔的位置
     * @return Response           開始下載的回應
     */
    private function saveAndExportSqlFile()
    {
        $db = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');

        //匯出的目錄
        $path = storage_path('app/exports');
        //匯出檔案的名稱
        $filename = $db.'_'.(Carbon::now()->format('Ymd_His')).'.sql';
        $realPath = $path.'/'.$filename;

        //使用mysqldump指令來儲存SQL檔案
        //設定為完整備份(Insert語法包含欄位名稱)，
        //且不備份Create Table的指令
        //產生insert 語法後，
        //在Lock Tables的語法後面插入TRUNCATE TABLE
        $command = "mysqldump -u".$db_user." -p".$db_password." ".$db;
        $command .= " --no-create-info --complete-insert"; 
        $command .= " | sed -r 's/LOCK TABLES (`[^`]+`) WRITE;/";//
        $command .= "LOCK TABLES \\1 WRITE; TRUNCATE TABLE \\1;/g'";
        $command .= " > ".$realPath;

        exec($command, $output);
        //開始下載

        return response()->download($path.'/'.$filename);
    }

    /**
     * 將上傳檔案
     * @param  string $realPath Sql檔案的位置
     * @return response   回到上一頁並且顯示錯誤或成功訊息
     */
    private function importSqlFileToMysql($path, $filename)
    {
        $realPath = $path.'/'.$filename;
        $db = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');

        $command = 'mysql -u'.$db_user.' -p'.$db_password.' '.$db.' < '.$realPath
            .' 2 > '.$path.'/import_logs.txt';
        exec($command, $output);

        $output = Storage::get('imports/import_logs.txt');
        dd($command."<br>".$output);
        if (count($output) == 0) {
            $status = new MessageBag(['資料庫還原完成!!']);
            return back()->with(['status' => $status]);
        } else {
            $errors = new MessageBag(['資料庫還原失敗!!']);
            return back()->withErrors($errors);
        }
    }
}
