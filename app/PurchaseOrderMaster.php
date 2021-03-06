<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PurchaseOrderMaster
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PurchaseOrderDetail[] $purchase_order_detail
 * @property-read \Supplier\Supplier $supplier
 * @mixin \Eloquent
 */
class PurchaseOrderMaster extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_order_master';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 回傳這個採購單表頭所有的庫存數量
     * @return [type] [description]
     */
    public function purchase_order_detail()
    {
        return $this->hasMany('App\PurchaseOrderDetail', 'master_code', 'code');
    }

    /**
     * 回傳這個採購單表頭所有的庫存數量
     * @return [type] [description]
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier\Supplier', 'supplier_code', 'code');
    }
}
