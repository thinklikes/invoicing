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
}
