<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        //Arrange
        /**
         * 建立物件 (待測物件，相依物件，Mock物件）。
         * 建立假資料。
         * 設定期望值
         */
        //Act
        /**
         * 實際執行待測物件的method，獲得實際值。
         */
        //Assert
        /**
         * 使用PHPUnit提供的assertion，測試期望值與實際值是否相等
         */
        // $this->visit('/test')
        //      ->see('Laravel 5');
    }
}
