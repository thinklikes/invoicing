<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * 所有進銷存控制器的父類別
 */
class BasicController extends Controller
{
    /**
     * 這個父類別的namespace
     * @var String
     */
    private $baseControllerNamespace = __NAMESPACE__;

    /**
     * 這個數值會存入每一個繼承類別的類別名稱
     * @var string
     */
    protected $className;

    /**
     * 這個函式會回傳每一個繼承類別的完整類別名稱
     * @return string
     */
    protected function getFullClassName() {
        return get_class($this);
    }

    /**
     * 這個函式會使每一個繼承類別的完整類別名稱
     * 排除基本的namespace:App\Http\Controllers
     * @return string
     */
    protected function exceptBaseNamesapce($name)
    {
        $name = str_replace($this->baseControllerNamespace."\\", '', $name);
        return $name;
    }

    /**
     * 排除基本的namespace後，存入className
     * @return void
     */
    protected function setFullClassName() {
        $this->className = $this->exceptBaseNamesapce($this->getFullClassName());
    }
}
