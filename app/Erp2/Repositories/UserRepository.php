<?php
namespace Erp\Repositories;

use App;
use App\User;
use App\Repositories\BasicRepository;

class UserRepository extends BasicRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsersPaginated($counts, $param = [])
    {
        return $this->user->where(function ($query) use($param) {
            if (isset($param['emp_name']) && $param['emp_name'] != "") {
                $query->where('emp_name', 'like', "%".trim($param['emp_name'])."%");
            }
            if (isset($param['employee_id']) && $param['employee_id'] != "") {
                $query->where('employee_id', 'like', "%".trim($param['employee_id'])."%");
            }
        })
        ->where('leavl', '!=', 9)
        ->paginate($counts);
    }

    public function getUsersWithOutSuperAdmin()
    {
        return $this->user->where('leavl', '!=', 9)->get();
    }


    public function getUserByEmployeeId($employee_id)
    {
        return $this->user->where('employee_id', $employee_id)->firstOrFail();
    }

    public function store($user)
    {

        $this->user = App::make(User::class);
        //判斷request傳來的欄位是否存在，有才存入此欄位數值
        $this->user->fill($user);

        //開始存入表頭
        return [$this->user->save(), $this->user->employee_id];
    }
    /**
     * 更新使用者帳號，若沒有異動則不更新
     * @param  string $employee_id 使用者的代號
     * @param  string $name        使用者的帳號
     * @return void
     */
    public function updateAccount($employee_id, $name)
    {
        $this_user = $this->getUserByEmployeeId($employee_id);

        if ($this_user->name != $name) {
            $this_user->name = $name;
            $this_user->save();
        }
    }
    /**
     * 更新使用者密碼，若沒有異動則不更新
     * @param  string $employee_id 使用者的代號
     * @param  string $password    使用者的密碼
     * @return void
     */
    public function updatePassword($employee_id, $password)
    {
        $this_user = $this->getUserByEmployeeId($employee_id);

        if ($this_user->password != $password) {
            $this_user->password = $password;
            $this_user->save();
        }
    }

    /**
     * 更新使用者等級，若沒有異動則不更新
     * @param  string $employee_id 使用者的密碼
     * @param  string $level        使用者的等級
     * @return void
     */
    public function updateLevel($employee_id, $level)
    {
        $this_user = $this->getUserByEmployeeId($employee_id);

        if ($this_user->leavl != $level) {
            $this_user->leavl = $level;
            $this_user->save();
        }
    }

    /**
     * 更新除了帳號密碼以外的資訊
     * @param  integer $id The id of purchase
     * @return void
     */
    public function update($employee_id, $user)
    {

        $this->user = $this->user
            ->where('employee_id', $employee_id)
            ->first();

        $this->user->fill($user);

        //開始存入資料
        return $this->user->save();
    }
    /**
     * 刪除一個使用者資料
     * @param  integer $id The id of purchase
     * @return void
     */
    public function delete($employee_id)
    {
        return $this->user
            ->where('employee_id', $employee_id)
            ->first()
            ->delete();
    }
}
