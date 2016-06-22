<?php
use App\StockWarehouse;
use App\Services\Purchase\BillOfPurchaseService;
use App\Purchase\BillOfPurchaseMaster as OrderMaster;
use App\Purchase\BillOfPurchaseDetail as OrderDetail;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillOfPurchaseServiceTest extends TestCase
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
         * 實體化
         */
        $target = App::make(BillOfPurchaseService::class);
        /**
         * Assert
         * 測試實體化是否成功
         */
        $this->assertTrue(is_object($target));
        return $target;
    }

    /**
     * 測試BillOfPurchaseService類別的create方法
     * @depends test_new
     */
    public function test_create($target)
    {
        //產生假資料
        $num = 5;
        $code = date('Ymd').'001';
        $orderMaster = factory(OrderMaster::class)->make([
            'code' => $code
        ]);
        $orderDetail = factory(OrderDetail::class, $num)->make([
            'master_code' => $code
        ]);
        for ($i = 0; $i < $num; $i++) {
            factory(StockWarehouse::class)->create([
                'stock_id' => $orderDetail[$i]->stock_id,
                'warehouse_id' => $orderMaster->warehouse_id,
                'inventory' => 0
            ]);
        }

        //使用BillOfPurchaseService類別的create方法存入資料
        $actual = $target->create($orderMaster, $orderDetail);

        $this->assertTrue($actual);
    }
    /**
     * 測試BillOfPurchaseService類別的update方法
     * @depends test_new
     */
    public function test_update($target)
    {
        //資料庫內先建立假資料
        $num = 5;
        $old_orderMaster = factory(OrderMaster::class)->create();
        $old_orderDetail = factory(OrderDetail::class, $num)->create([
            'master_code' => $old_orderMaster->code
        ]);
        //另外產生假資料，但是code是一樣的
        $new_orderMaster = factory(OrderMaster::class)->make([
            'code' => $old_orderMaster->code
        ]);
        $new_orderDetail = factory(OrderDetail::class, $num)->make([
            'master_code' => $old_orderMaster->code
        ]);
        for ($i = 0; $i < $num; $i++) {
            factory(StockWarehouse::class)->create([
                'stock_id' => $old_orderDetail[$i]->stock_id,
                'warehouse_id' => $old_orderMaster->warehouse_id,
                //'inventory' => $old_orderDetail[$i]->inventory
            ]);
            factory(StockWarehouse::class)->create([
                'stock_id' => $new_orderDetail[$i]->stock_id,
                'warehouse_id' => $new_orderMaster->warehouse_id,
                'inventory' => 0
            ]);
        }
        $actual = $target->update($new_orderMaster, $new_orderDetail, $old_orderMaster->code);

        $this->assertTrue($actual);
    }

    // public function test_delete($value='')
    // {
    //     # code...
    // }
    // public function test_retrunStockInventory($value='')
    // {
    //     # code...
    // }
}