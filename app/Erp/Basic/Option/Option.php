<?php

namespace Option;

use Illuminate\Database\Eloquent\Model;

/**
 * Option\Option
 *
 * @property integer $id
 * @property string $class 此記錄的類別
 * @property string $code 此類別的代碼
 * @property string $comment 此類別代碼的說明
 * @property string $value 此類別代碼的數值
 * @method static \Illuminate\Database\Query\Builder|\Option\Option whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Option\Option whereClass($value)
 * @method static \Illuminate\Database\Query\Builder|\Option\Option whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Option\Option whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\Option\Option whereValue($value)
 * @mixin \Eloquent
 */
class Option extends Model
{
    protected $table = 'erp_options';

    public $timestamps = false;
}