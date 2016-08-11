<?php

namespace StockTransfer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * StockTransfer\StockTransferMaster
 *
 * @property integer $id
 * @property string $code 轉倉單號
 * @property integer $from_warehouse_id 調出倉庫的id
 * @property integer $to_warehouse_id 調入倉庫的id
 * @property integer $total_amount 總金額
 * @property string $note 轉倉單備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Warehouse\Warehouse $from_warehouse
 * @property-read \Warehouse\Warehouse $to_warehouse
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereFromWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereToWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\StockTransfer\StockTransferMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class StockTransferMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stock_transfer_master';
    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function from_warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'from_warehouse_id', 'id');
    }
    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function to_warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'to_warehouse_id', 'id');
    }
}
