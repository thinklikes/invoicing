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
    /**
     * sidebar顯示的欄位
     * @var array
     */
    private $sidebarFields = [
        'employee_id' => '使用者代號',
        'emp_name' => '使用者姓名',
    ];
    /**
     * index page顯示的欄位
     * @var array
     */
    private $indexFields = [
        'employee_id' => '使用者代號',
        'emp_name' => '使用者姓名',
        'leavl' => '使用者權限',
    ];
    /**
     * show page顯示的欄位
     * @var array
     */
    private $showFields = [
        'head' => [
            'employee_id' => ['title' => '使用者代號', 'type' => 'text'],
            'emp_name'    => ['title' => '使用者姓名', 'type' => 'text'],
            //'name'        => ['title' => '使用者帳號', 'type' => 'text'],
            'email'       => ['title' => '電子郵件', 'type' => 'text'],
            'phone'       => ['title' => '電話', 'type' => 'text'],
            'out_at'      => ['title' => '離職日', 'type' => 'date'],
            'remark'      => ['title' => '備註', 'type' => 'textarea'],
        ]
    ];
    /**
     * create or edit page顯示的欄位
     * @var array
     */
    private $formFields = [
        'head' => [
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
        ]
    ];
    /**
     * create or edit page必填的欄位
     * @var array
     */
    public static $required = [
        'head' => ['employee_id', 'emp_name', 'name', 'password', 'password2']
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
    public function getDataPaginated($param)
    {
        $data = $this->user->getUsersPaginated($this->counts, $param);

        $data->map(function ($item, $key) {
            $item->leavl = $this->levels[$item->leavl];
            return $item;
        });

        return $data;
    }

    /**
     * 依照輸入的代碼找出所屬資料
     * @param  string $employee_id 員工代號
     * @return App\User            員工資料
     */
    public function getDataByCode($employee_id)
    {
        return $this->user->getUserByEmployeeId($employee_id);
    }

    /**
     * 在開啟create form之前重整資料
     * @param  array or null $data  重整前的資料
     * @return array or null       重整後的資料
     */
    public function reformDataBeforeCreate($data = null)
    {
        if ($data) {
            foreach($data as $key => $item) {
                $fields = $this->formFields['head'];

                if ($fields[$key]['type'] == 'password') {
                    $data[$key] = '';
                }
            }
        }

        return $data;
    }

    /**
     * 在開啟create form之前重整資料
     * @param  array or null $data  重整前的資料
     * @return array or null       重整後的資料
     */
    public function reformDataBeforeEdit($data = null)
    {
        if (gettype($data) == 'array') {
            foreach($data as $key => $item) {
                $fields = $this->formFields['head'];

                if ($fields[$key]['type'] == 'password') {
                    $data[$key] = '';
                }
            }
        } else {
            $data->password2 = $data->password;
        }

        return $data;
    }

    public function create($listener, $head, $body = null)
    {
        $isCreated = true;
        //密碼設定為雜湊
        $head['password'] = bcrypt($head['password']);

        $head['email'] = $head['email'] == '' ? null : $head['email'];

        //新增表頭資料
        $reuslt = $this->user->store($head);

        $isCreated = $isCreated && $reuslt[0];
        //更新帳號
        $this->user->updateAccount($reuslt[1], $head['name']);
        //更新密碼
        $this->user->updatePassword($reuslt[1], $head['password']);

        //return $isCreated;
        if (!$isCreated) {
            return $listener->orderCreatedErrors(
                new MessageBag([$this->chname.'新增失敗!']));

        }
        return $listener->orderCreated(
            new MessageBag([$this->chname.'新增成功!']), $reuslt[1]);
    }

    public function update($employee_id, $listener, $head, $body = null)
    {
        $isUpdated = true;

        //密碼設定為雜湊
        $head['password'] = bcrypt($head['password']);

        $head['email'] = $head['email'] == '' ? null : $head['email'];

        //先存入表頭
        $isUpdated = $isUpdated && $this->user->update(
            $employee_id, $head
        );

        //更新帳號
        $this->user->updateAccount($employee_id, $head['name']);
        //更新密碼
        $this->user->updatePassword($employee_id, $head['password']);

        //return $isUpdated;
        if (!$isUpdated) {
            return $listener->orderUpdatedErrors(
                new MessageBag(['客戶更新失敗!'])
            );
        }
        return $listener->orderUpdated(
            new MessageBag(['客戶已更新!']), $employee_id
        );
    }

    public function delete($listener, $employee_id)
    {
        $isDeleted = true;

        //將這張單作廢
        $isDeleted = $isDeleted && $this->user->delete($employee_id);
        //$this->company->deleteOrderDetail($code);

        if (!$isDeleted) {
            return $listener->orderDeletedErrors(
                new MessageBag(['客戶刪除失敗!'])
            );
        }
        return $listener->orderDeleted(
            new MessageBag(['客戶已刪除!']), $employee_id
        );
    }
}