<?php
namespace Erp\Services;

use Erp\Services\ErpServiceInterface;
use Erp\Repositories\UserRepository as User;
use Illuminate\Support\MessageBag;

class UserService implements ErpServiceInterface
{
    private $user;
    private $property = [];

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->property = [
            'chname' => '使用者',
            'title' => [
                'employee_id' => '使用者代號',
                'emp_name' => '使用者姓名',
                'level' => '使用者權限',
            ]
        ];
    }

    public function getProperty($key)
    {
        return $this->property[$key];
    }

    public function getAllItemNamesAndCodes() {
        //return $this->company->getAllItemNamesAndCodes();
    }

    public function getAppIndexPage($value='')
    {
        // return view($this->routeName.'.index', [
        //     'code' => $request->input('code'),
        //     'name' => $request->input('name'),
        //     'address' => $request->input('address'),
        //     'company' => $this->Company
        //         ->getCompanyPaginated(
        //             array_except($request->input(), 'page'),
        //             $this->ordersPerPage)
        // ]);
    }


    public function create($master, $details = null)
    {
        // $isCreated = true;
        // //新增表頭資料
        // $reuslt = $this->company->storeCompany($orderMaster);

        // $isCreated = $isCreated && $reuslt[0];

        // //return $isCreated;
        // if (!$isCreated) {
        //     return ['error' => new MessageBag(['客戶開單失敗!'])];

        // }
        // return [
        //     'success' => new MessageBag(['客戶已新增!']), $reuslt[1]
        // ];
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