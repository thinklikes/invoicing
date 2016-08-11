<?php

namespace StockAdjust;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * StockAdjust\StockAdjustMaster
 *
 * @property integer $id
 * @property string $code 調整單號
 * @property integer $warehouse_id 倉庫的id
 * @property integer $total_amount 總金額
 * @property string $note 調整單備註
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\StockAdjust\StockAdjustDetail[] $orderDetail
 * @property-read \Warehouse\Warehouse $warehouse
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\StockAdjust\StockAdjustMaster whereDeletedAt($value)
 * @mixin \Eloquent
 */
class StockAdjustMaster extends Model
{
    use SoftDeletes;

    protected $table = 'erp_stock_adjust_master';

    /**
     * 回傳這個表頭所屬的表身細項
     * @return [type] [description]
     */
    public function orderDetail()
    {
        return $this->hasMany('StockAdjust\StockAdjustDetail', 'master_code', 'code');
    }

    /**
     * 回傳表頭的倉庫
     * @return [type] [description]
     */
    public function warehouse()
    {
        return $this->belongsTo('Warehouse\Warehouse', 'warehouse_id', 'id');
    }
}
