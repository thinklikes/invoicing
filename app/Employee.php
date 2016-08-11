<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Employee
 *
 * @property integer $id 員工資料表主鍵
 * @property string $code 員工編號
 * @property string $name 姓名
 * @property string $gender 性別
 * @property string $email 電子郵件
 * @property string $telphone 電話號碼
 * @property string $cellphone 行動電話號碼
 * @property boolean $county_id 縣市別的id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereTelphone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCellphone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Employee extends Model
{
    protected $table = 'erp_employees';
    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = ['name'];
}
