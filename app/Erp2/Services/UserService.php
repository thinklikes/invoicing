<?php
namespace Erp\Services;

use Erp\Services\ErpServiceInterface;
use Erp\Repositories\UserRepository as User;
use Illuminate\Support\MessageBag;

class UserService implements ErpServiceInterface
{
    private $user;
    private $chname = '使用者';
    private $headName = 'user';
    private $bodyName = '';
    private $counts = 15;
    private $levels = [
        9 => '超級管理者',
        1 => '系統管理者',
        0 => '一般使用者',
        -1 => '來賓'
    ];
    private $sidebarFields = [
        'employee_id' => '使用者代號',
        'emp_name' => '使用者姓名',
    ];
    private $indexFields = [
        'employee_id' => '使用者代號',
        'emp_name' => '使用者姓名',
        'leavl' => '使用者權限',
    ];
    private $headFields = [
        'employee_id' => ['title' => '使用者代號', 'type' => 'text'],
        'emp_name'    => ['title' => '使用者姓名', 'type' => 'text'],
        'name'        => ['title' => '使用者帳號', 'type' => 'text'],
        'password'    => ['title' => '使用者密碼', 'type' => 'password'],
        'password2'    => ['title' => '再次輸入密碼', 'type' => 'password'],
        'email'       => ['title' => '電子郵件', 'type' => 'text'],

        'phone'       => ['title' => '電話', 'type' => 'text'],
        'out_at'      => ['title' => '離職日', 'type' => 'date'],
        // 'leavl'       => [
        //     'title' => '使用者權限',
        //     'type' => 'select',
        //     'source' => [
        //         'admin' => '系統管理者',
        //         'user' => '一般使用者',
        //         'demo' => '來賓'
        //     ]
        // ],
        'remark'      => ['title' => '備註', 'type' => 'textarea'],
    ];
    public static $required = [
        'user' => ['employee_id', 'emp_name', 'name', 'password', 'password2']
    ];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getProperty($key)
    {
        if ($key == 'required') {
            return self::$required;
        }
        return $this->{$key};
    }
    /**
     * 取得首頁資料
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function getAppIndexData($param)
    {
        $data = $this->user->getUsersPaginated($this->counts, $param);

        $data->map(function ($item, $key) {
            $item->leavl = $this->levels[$item->leavl];
            return $item;
        });

        return $data;
    }

    public function getAppShowData($employee_id)
    {
        $data = $this->user->getUserByEmployeeId($employee_id);

        //不顯示密碼
        return $data->toArray();
        // $data->code = $data->employee_id;

        // return $data;
    }

    public function create($listener, $master, $details = null)
    {
        $isCreated = true;
        //密碼設定為雜湊
        $master['password'] = bcrypt($master['password']);

        //新增表頭資料
        $reuslt = $this->user->store($master);

        $isCreated = $isCreated && $reuslt[0];

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag([$this->chname.'新增失敗!']));

        }
        return $listener->orderCreated(
            new MessageBag([$this->chname.'新增成功!']), $reuslt[1]);
    }

    public function update($key, $value, $master, $details = null)
    {
        // $isUpdated = true;

        // //先存入表頭
        // $isUpdated = $isUpdated && $this->company->updateCompany(
        //     $orderMaster, $id
        // );

        // //return $isUpdated;
        // if (!$isUpdated) {
        //     return $listener->orderUpdatedErrors(
        //         new MessageBag(['客戶更新失敗!'])
        //     );
        // }
        // return $listener->orderUpdated(
        //     new MessageBag(['客戶已更新!']), $id
        // );
    }

    public function delete($key, $value)
    {
        // $isDeleted = true;

        // //將這張單作廢
        // $isDeleted = $isDeleted && $this->company->deleteCompany($id);
        // //$this->company->deleteOrderDetail($code);

        // if (!$isDeleted) {
        //     return $listener->orderDeletedErrors(
        //         new MessageBag(['客戶刪除失敗!'])
        //     );
        // }
        // return $listener->orderDeleted(
        //     new MessageBag(['客戶已刪除!']), $id
        // );
    }
}