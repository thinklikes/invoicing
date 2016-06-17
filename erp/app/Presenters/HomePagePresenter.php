<?php

namespace App\Presenters;

class HomePagePresenter
{
    /**
     * 顯示系統訊息用
     * @param  array/MessageBag $status 系統訊息
     * @return string      產生html的訊息框
     */
    public function showStatus($status)
    {
        if (!empty($status)) {
            if (gettype($status) != "array") {
                $status = $status->all();
            }
            $status_box = "";
            $status_box .= "<div class=\"alert alert-success\">";
            $status_box .= "<ul>";
            foreach ($status as $value) {
                $status_box .= "<li>$value</li>";
            }
            $status_box .= "</ul>";
            $status_box .= "</div>";

            return $status_box;
        }
    }

    /**
     * 顯示系統錯誤訊息用
     * @param  MessageBag $error 系統錯誤訊息
     * @return string      產生html的錯誤訊息框
     */
    public function showErrors($errors)
    {
        if (count($errors) > 0) {
            $errors_box = "";
            $errors_box .= "<div class=\"alert alert-danger\">";
            $errors_box .= "<ul>";
            foreach ($errors->all() as $error) {
                $errors_box .= "<li>$error</li>";
            }
            $errors_box .= "</ul>";
            $errors_box .= "</div>";

            return $errors_box;
        }
    }

}