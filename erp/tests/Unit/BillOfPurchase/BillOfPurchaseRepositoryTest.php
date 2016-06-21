<?php
use App\Basic\Supplier;
use App\Basic\Stock;
use App\Purchase\BillOfPurchaseMaster;
use App\Purchase\BillOfPurchaseDetail;
use App\Repositories\Purchase\BillOfPurchaseRepository;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillOfPurchaseRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_new()
    {
        /**
         * Arrange
         * 實體化BillOfPurchaseRepository
         */
        $target = new BillOfPurchaseRepository(
            new BillOfPurchaseMaster,
            new BillOfPurchaseDetail
        );

        /**
         * Assert
         * 測試實體化是否成功
         */
        $this->assertTrue(is_object($target));
        return $target;
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
        $data = factory(BillOfPurchaseMaster::class)->make();

        /**
         * Act
         * 存入表頭
         */
        $actual_1 = $target->storeOrderMaster($data);

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
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
        $data = factory(BillOfPurchaseDetail::class)->make();
        $code = $data->master_code;
        unset($data->master_code);
        /**
         * Act
         * 存入表身
         */
        $actual_1 = $target->storeOrderDetail($data, $code);

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
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

        $data1 = factory(BillOfPurchaseMaster::class)->create();
        $data2 = factory(BillOfPurchaseMaster::class)->make();
        $code = $data1->code;
        unset($data2->code);

        /**
         * Act
         * 更新表頭
         */
        $actual_1 = $target->updateOrderMaster($data2, $code);

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
    }

    /**
     * 測試更新表身
     * @depends test_new
     */
    public function test_store_OrderDetail($target) {
        /**
         * Arrange
         * 1. 在表身資料表中先存入一筆表身資料
         * 2. 產生一筆假資料
         * 3. 將code換成舊的
         */
        $data1 = factory(BillOfPurchaseDetail::class)->create();
        $data2 = factory(BillOfPurchaseDetail::class)->make();
        $code = $data1->master_code;
        unset($data2->master_code);

        /**
         * Act
         * 更新表身
         */
        $actual_1 = $target->storeOrderDetail($data2, $code);

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
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

        /**
         * Assert
         * 測試是否成功
         */
        $this->assertTrue($actual_1);
    }

    /**
     * 測試存取表頭
     * @depends test_new
     */
    public function test_store_and_get_OrderMaster($obj)
    {
        //Arrange
        $target = $obj;
        //factory(Supplier::class, 50)->create();
        $orderMaster = factory(BillOfPurchaseMaster::class)->make();

        //Act
        $actual_1 = $target->storeOrderMaster($orderMaster);
        $actual_2 = $target->getOrderMaster($orderMaster->code);
        //Assert
        $this->assertTrue($actual_1);
        $this->assertEquals($orderMaster->code, $actual_2->code);
    }

    /**
     * 測試存入表身
     * @depends test_new
     */
    public function test_store_and_get_OrderDeail($obj)
    {
        //測試存入表身
        //Arrange
        $target = $obj;
        $num = 5;
        $orderDetail = factory(BillOfPurchaseDetail::class, $num)->make();
        for ($i = 0; $i < $num; $i++) {
            unset($orderDetail[$i]->master_code);
            $code = date('Ymd').sprintf('%03d', $i+1);
            //Act
            $actual_1 = $target->storeOrderDetail($orderDetail[$i], $code);
            $actual_2 = $target->getOrderDetail($code);
            $this->assertTrue($actual_1);
            //Assert
            $this->assertEquals($code, $actual_2[0]->master_code);
            $this->assertEquals($orderDetail[$i]->stock_id, $actual_2[0]->stock_id);
            $this->assertEquals($orderDetail[$i]->quantity, $actual_2[0]->quantity);
            $this->assertEquals($orderDetail[$i]->no_tax_price, $actual_2[0]->no_tax_price);
        }
    }

    /**
     * 測試更新表頭
     * @depends test_new
     */
    public function test_update_and_get_OrderMaster($obj)
    {
        /**
         * Arrange
         */
        $target = $obj;
        //先存入舊資料
        $old_orderMaster = factory(BillOfPurchaseMaster::class)->create();
        //取出舊資料
        $old_orderMaster = BillOfPurchaseMaster::find(1);
        $code = $old_orderMaster->code;
        //產生新資料但是code不變
        $new_orderMaster = factory(BillOfPurchaseMaster::class)->make();
        unset($new_orderMaster->code);

        /**
         * Act
         */
        $actual_1 = $target->updateOrderMaster($new_orderMaster, $code);
        $actual_2 = $target->getOrderMaster($code);

        /**
         * Assert
         */
        $this->assertTrue($actual_1);
        $this->assertEquals($old_orderMaster->code, $actual_2->code);
    }

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