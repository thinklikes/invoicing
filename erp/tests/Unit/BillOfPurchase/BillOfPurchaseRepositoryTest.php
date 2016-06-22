<?php

use Illuminate\Support\Collection;
use App\Purchase\BillOfPurchaseMaster;
use App\Purchase\BillOfPurchaseDetail;
use App\Repositories\Purchase\BillOfPurchaseRepository;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillOfPurchaseRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 測試實體化是否成功
     * @return void
     */
    public function test_new()
    {
        /**
         * Arrange
         * 實體化BillOfPurchaseRepository
         */
        $target = App::make(BillOfPurchaseRepository::class);

        /**
         * Assert
         * 測試實體化是否成功
         */
        $this->assertTrue(is_object($target));
        return $target;
    }

    /**
     * 測試回傳新單號
     * @depends test_new
     */
    public function test_getNewOrderCode($target)
    {
        /**
         * Arrange
         * 存入表頭假資料
         */
        $data = factory(BillOfPurchaseMaster::class)->create();
        $old_code = $data->code;
        /**
         * Act
         * 執行isOrderExsist
         */
        $actual_1 = $target->getNewOrderCode();
        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue((integer)$actual_1 == (integer)$old_code + 1);
    }

    /**
     * 抓出最新的15筆
     * @depends test_new
     */
    public function test_getOrdersPaginated($target)
    {
        /**
         * Arrange
         * 存入表頭假資料
         */
        $data = factory(BillOfPurchaseMaster::class, 50)->create();
        $expected = new Collection([
            50, 49, 48, 47, 46, 45, 44, 43, 42, 41, 40, 39, 38, 37, 36
        ]);
        /**
         * Act
         * 執行isOrderExsist
         */
        $actual_1 = $target->getOrdersPaginated(15);
        /**
         * Assert
         * 測試是否成功
         */
        $this->assertEquals($expected, $actual_1->pluck('id'));
    }
    /**
     * 抓出表頭資料
     * @depends test_new
     */
    public function test_getOrderMaster($target)
    {
        $data = factory(BillOfPurchaseMaster::class)->create();
        $code = $data->code;

        $actual_1 = $target->getOrderMaster($code);

        //測試存入的欄位是否跟取出的欄位值一樣
        $this->assertEquals($data->invoice_code, $actual_1->invoice_code);
        $this->assertEquals($data->warehouse_id, $actual_1->warehouse_id);
        $this->assertEquals($data->supplier_id, $actual_1->supplier_id);
        $this->assertEquals($data->tax_rate_code, $actual_1->tax_rate_code);
        $this->assertEquals($data->note, $actual_1->note);
    }
    /**
     * 抓出表身資料
     * @depends test_new
     */
    public function test_getOrderDetail($target)
    {
        $code = date('Ymd').'001';
        $data = factory(BillOfPurchaseDetail::class, 5)->create([
            'master_code' => $code
        ]);

        $actual_1 = $target->getOrderDetail($code);
        for($i=0; $i < 5; $i++) {
            //測試存入的欄位是否跟取出的欄位值一樣
            $this->assertEquals($data[$i]->stock_id, $actual_1[$i]->stock_id);
            $this->assertEquals($data[$i]->quantity, $actual_1[$i]->quantity);
            $this->assertEquals($data[$i]->no_tax_price, $actual_1[$i]->no_tax_price);
        }

    }
    /**
     * 測試存入表頭
     * @depends test_new
     */
    public function test_storeOrderMaster($target)
    {
        /**
         * Arrange
         * 產生表頭假資料
         */
        $code = date('Ymd').'001';
        $data = factory(BillOfPurchaseMaster::class)->make([
            'code' => $code
        ]);
        /**
         * Act
         * 存入表頭
         */
        $actual_1 = $target->storeOrderMaster($data);
        $actual_2 = BillOfPurchaseMaster::where('code', $code)->firstOrFail();
        /**
         * Assert
         * 存入的資料應該與第一筆資料相同
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
        $this->assertEquals($data->invoice_code, $actual_2->invoice_code);
        $this->assertEquals($data->warehouse_id, $actual_2->warehouse_id);
        $this->assertEquals($data->supplier_id, $actual_2->supplier_id);
        $this->assertEquals($data->tax_rate_code, $actual_2->tax_rate_code);
        $this->assertEquals($data->note, $actual_2->note);
    }

    /**
     * 測試存入表身
     * @depends test_new
     */
    public function test_storeOrderDetail($target)
    {
        /**
         * Arrange
         * 產生表身假資料，表身的code是另外存入
         */
        $num = 2;
        $code = date('Ymd').'001';
        $data = factory(BillOfPurchaseDetail::class, $num)->make([
            'master_code' => $code
        ]);
        /**
         * Assert
         * 測試是否成功
         */
        for($i=0; $i < $num; $i++) {

            /**
             * Act
             * 存入表身
             */
            $actual_1 = $target->storeOrderDetail($data[$i]);
            $actual_2 = BillOfPurchaseDetail::skip($i)->take(1)->firstOrFail();
            $this->assertTrue($actual_1);
            //測試存入的欄位是否跟取出的欄位值一樣
            $this->assertEquals($data[$i]->stock_id, $actual_2->stock_id);
            $this->assertEquals($data[$i]->quantity, $actual_2->quantity);
            $this->assertEquals($data[$i]->no_tax_price, $actual_2->no_tax_price);
        }
    }
    /**
     * 測試更新表頭
     * @depends test_new
     */
    public function test_updateOrderMaster($target)
    {
        /**
         * Arrange
         * 1. 存在表頭資料表中先存入一筆表頭資料
         * 2. 產生一筆假資料
         * 3. 將code換成舊的
         */
        $code = date('Ymd').'001';
        $data1 = factory(BillOfPurchaseMaster::class)->create([
            'code' => $code
        ]);
        $data2 = factory(BillOfPurchaseMaster::class)->make([
            'master_code' => $code
        ]);

        /**
         * Act
         * 更新表頭
         */
        $actual_1 = $target->updateOrderMaster($data2, $code);
        $actual_2 = BillOfPurchaseMaster::where('code', $code)->firstOrFail();

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
        $this->assertEquals($data2->invoice_code, $actual_2->invoice_code);
        $this->assertEquals($data2->warehouse_id, $actual_2->warehouse_id);
        $this->assertEquals($data2->supplier_id, $actual_2->supplier_id);
        $this->assertEquals($data2->tax_rate_code, $actual_2->tax_rate_code);
        $this->assertEquals($data2->note, $actual_2->note);
    }

    /**
     * 測試刪除表頭
     * @depends test_new
     */
    public function test_deleteOrderMaster($target)
    {
        /**
         * Arrange
         * 1. 在表身資料表中先存入一筆表身資料
         * 2. 找出code
         */
        $data1 = factory(BillOfPurchaseMaster::class)->create();
        $code = $data1->code;

        /**
         * Act
         * 刪除表頭
         */
        $actual_1 = $target->deleteOrderMaster($code);
        $actual_2 = BillOfPurchaseMaster::where('code', $code)->first();

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1 !== false);
        $this->assertNull($actual_2);
    }

    /**
     * 測試刪除表身
     * @depends test_new
     */
    public function test_deleteOrderDetail($target)
    {
        /**
         * Arrange
         * 1. 在表身資料表中先存入多筆表身資料
         * 2. 找出code
         */
        $code = date('Ymd').'999';
        $data1 = factory(BillOfPurchaseDetail::class, 5)->create([
            'master_code' => $code
        ]);


        /**
         * Act
         * 刪除表頭
         */
        $actual_1 = $target->deleteOrderDetail($code);
        $actual_2 = BillOfPurchaseMaster::where('master_code', $code)->get();
        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1 !== false);
        $this->assertCount(0, $actual_2);
    }

    /**
     * 測試存取表頭
     * @depends test_new
     */
    // public function test_store_and_get_OrderMaster($obj)
    // {
    //     //Arrange
    //     $target = $obj;
    //     //factory(Supplier::class, 50)->create();
    //     $orderMaster = factory(BillOfPurchaseMaster::class)->make();

    //     //Act
    //     $actual_1 = $target->storeOrderMaster($orderMaster);
    //     $actual_2 = $target->getOrderMaster($orderMaster->code);
    //     //Assert
    //     $this->assertTrue($actual_1);
    //     $this->assertEquals($orderMaster->code, $actual_2->code);
    // }

    /**
     * 測試存入表身
     * @depends test_new
     */
    // public function test_store_and_get_OrderDeail($obj)
    // {
    //     //測試存入表身
    //     //Arrange
    //     $target = $obj;
    //     $num = 5;
    //     $orderDetail = factory(BillOfPurchaseDetail::class, $num)->make();
    //     for ($i = 0; $i < $num; $i++) {
    //         unset($orderDetail[$i]->master_code);
    //         $code = date('Ymd').sprintf('%03d', $i+1);
    //         //Act
    //         $actual_1 = $target->storeOrderDetail($orderDetail[$i], $code);
    //         $actual_2 = $target->getOrderDetail($code);
    //         $this->assertTrue($actual_1);
    //         //Assert
    //         $this->assertEquals($code, $actual_2[0]->master_code);
    //         $this->assertEquals($orderDetail[$i]->stock_id, $actual_2[0]->stock_id);
    //         $this->assertEquals($orderDetail[$i]->quantity, $actual_2[0]->quantity);
    //         $this->assertEquals($orderDetail[$i]->no_tax_price, $actual_2[0]->no_tax_price);
    //     }
    // }

    /**
     * 測試更新表頭
     * @depends test_new
     */
    // public function test_update_and_get_OrderMaster($target)
    // {
    //     /**
    //      * Arrange
    //      */
    //     //先存入舊資料
    //     $old_orderMaster = factory(BillOfPurchaseMaster::class)->create();
    //     //取出舊資料
    //     $old_orderMaster = BillOfPurchaseMaster::find(1);
    //     $code = $old_orderMaster->code;
    //     //產生新資料但是code不變
    //     $new_orderMaster = factory(BillOfPurchaseMaster::class)->make();
    //     unset($new_orderMaster->code);

    //     /**
    //      * Act
    //      */
    //     $actual_1 = $target->updateOrderMaster($new_orderMaster, $code);
    //     $actual_2 = $target->getOrderMaster($code);

    //     /**
    //      * Assert
    //      */
    //     $this->assertTrue($actual_1);
    //     $this->assertEquals($old_orderMaster->code, $actual_2->code);
    // }

    /**
     * 測試更新表身
     * @depends test_new
     */
    // public function test_update_OrderDeail($obj)
    // {
    //     //測試存入表身
    //     //Arrange
    //     $target = $obj;
    //     $num = 5;
    //     $orderDetail = factory(BillOfPurchaseDetail::class, $num)->make();

    //     for ($i = 0; $i < $num; $i++) {
    //         $code = $orderDetail[$i]->master_code;
    //         //Act
    //         $actual_1 = $target->storeOrderDetail($orderDetail[$i], $code);
    //         $actual_2 = $target->getOrderDetail($code);
    //         $this->assertTrue($actual_1);
    //         //Assert
    //         $this->assertEquals($orderDetail[$i]->master_code, $actual_2[0]->master_code);
    //         $this->assertEquals($orderDetail[$i]->stock_id, $actual_2[0]->stock_id);
    //         $this->assertEquals($orderDetail[$i]->quantity, $actual_2[0]->quantity);
    //         $this->assertEquals($orderDetail[$i]->no_tax_price, $actual_2[0]->no_tax_price);
    //     }
    // }
}