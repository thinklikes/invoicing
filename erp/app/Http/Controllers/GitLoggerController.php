<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class GitLoggerController extends Controller
{
    public function index($page = 0)
    {
        //顯示git更新記錄
        if (!$page) {
            $page = 0;
        }
        $skip = 10 * $page;

        exec('git log -10 --skip='.$skip.' --format=%cd%s --date=iso --grep="\[visiable\]"'
            , $git_logs);
        //exec('whoami', $output);
        $logs = '';
        $i = 0;
        foreach ($git_logs as $line => $content) {
            $logs .= str_replace('[visiable]', '<br>', (trim($content)))."<br><br>";
            $i ++;

        }
        return nl2br($logs);
    }
}
