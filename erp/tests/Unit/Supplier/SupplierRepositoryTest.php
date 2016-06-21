<?php

use App\Basic\Supplier;
use App\Repositories\Basic\SupplierRepository;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SupplierRepositoryTest extends TestCase
{
    use DatabaseMigrations;
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
    /**
     * 測試首頁是否叫出15個
     * @return void
     */
    public function test_method_getSuppliersPaginated()
    {
        //Arrange
        //建立物件
        $target = new SupplierRepository();
        //建立假資料。
        factory(Supplier::class, 50)->create();
        //設定期望值
        $expected = 15;

        //act
        $actual = $target->getSuppliersPaginated([]);

        //Assert
        $this->assertCount($expected, $actual);
    }

    /**
     * 測試供應商的詳細資料是否有成功叫出
     * @return void
     */
    public function test_method_getSupplierDetail()
    {
        //Arrange
        //建立物件
        $target = new SupplierRepository();
        //建立假資料。
        factory(Supplier::class, 50)->create();
        //設定期望值
        $expected = 1;

        //act
        $actual = $target->getSupplierDetail($expected);

        //Assert
        $this->assertEquals($expected, $actual->id);
    }

    /**
     * 測試有成功存入供應商
     * @return void
     */
    public function test_method_storeSupplier()
    {
        //Arrange
        //建立物件
        $target = new SupplierRepository();
        //建立假資料。
        $data = factory(Supplier::class)->make();
        //設定期望值
        $expected = 1;

        //act
        $actual = $target->storeSupplier($data);

        //Assert
        $this->assertEquals($expected, $actual);
    }
}
