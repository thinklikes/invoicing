<?php

namespace StockInLogs;

use App;
use App\Repositories\BasicRepository;
use StockInLogs\StockInLogs as MainModel;
use DB;

/**
 *
 */
class StockInLogsRepository extends BasicRepository
{
    protected $mainModel;
    /**
     * StockInLogsRepository constructor.
     *
     * @param StockInLogs\StockInLogs $mainModel
     */
    public function __construct(MainModel $mainModel)
    {
        $this->mainModel = $mainModel;
    }

    /**
     * find a page of orders
     * @return array all purchases
     */
    public function getOrdersPaginated($ordersPerPage)
    {
        return $this->mainModel->orderBy('id', 'desc')->paginate($ordersPerPage);
    }

    /**
     * store billOfPurchaseMaster
     * @param  Array billOfPurchaseMaster
     * @return boolean
     */
    public function store($data)
    {
        $columns = $this->getTableColumnList($this->mainModel);

        $this->mainModel->newInstance();

        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        foreach($data as $key) {
            if (isset($orderMaster[$key])) {
                $this->mainModel->{$key} = $orderMaster[$key];
            }
        }

        //開始存入表頭
        return $this->mainModel->save();
    }

    /**
     * delete a Purchase
     * @param  integer $id The id of purchase
     * @return void
     */
    public function delete($code)
    {
        return $this->mainModel
            ->where('code', $code)
            ->delete();
    }
}