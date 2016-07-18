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

    /**
     * 單據建立完成後的轉址
     * @param  array $status 狀態說明及代碼
     * @param  string $code   單據號碼
     * @return response         回傳的頁面
     */
    public function orderCreated($status, $code)
    {
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with(['status' => $status]);
    }
    /**
     * 單據建立錯誤時的轉址
     * @param  array $errors 錯誤說明及代碼
     * @return response         回傳的頁面
     */
    public function orderCreatedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }

    /**
     * 單據更新完成後的轉址
     * @param  array $status 狀態說明及代碼
     * @param  string $code   單據號碼
     * @return response         回傳的頁面
     */
    public function orderUpdated($status, $code)
    {
        return redirect()->action($this->className.'@show', ['code' => $code])
            ->with(['status' => $status]);
    }
    /**
     * 單據更新錯誤時的轉址
     * @param  array $errors 錯誤說明及代碼
     * @return response         回傳的頁面
     */
    public function orderUpdatedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }
    /**
     * 單據刪除完成後的轉址
     * @param  array $status 狀態說明及代碼
     * @param  string $code   單據號碼
     * @return response         回傳的頁面
     */
    public function orderDeleted($status, $code)
    {
        return redirect()->action($this->className.'@index')->with(['status' => $status]);
    }
    /**
     * 單據刪除錯誤時的轉址
     * @param  array $errors 錯誤說明及代碼
     * @return response         回傳的頁面
     */
    public function orderDeletedErrors($errors)
    {
        return back()->withInput()->withErrors($errors);
    }
}
