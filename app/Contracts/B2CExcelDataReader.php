<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

/*
 * 規定EXCEL讀取器的介面
*/

interface B2CExcelDataReader
{
    public function loadData($filename);
}