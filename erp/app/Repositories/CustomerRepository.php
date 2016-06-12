<?php

namespace App\Repositories;

use App\Customer;

class CustomerRepository
{
    /**
     * find One page of customers
     * @param  array $param 搜尋的條件
     * @return array        搜尋到的客戶
     */
    public static function getCustomersOnePage($param)
    {
        if (count($param) > 0) {
            $customers = Customer::where('name', 'like', '%'.$param['name'].'%')
                ->where('address', 'like', '%'.$param['address'].'%')
                ->paginate(15);
        } else {
            $customers = Customer::paginate(15);
        }

        //$customers->setPath('customers/test/gogogo');
        return $customers;
    }
    /**
     * find detail of one customer
     * @param  integer $id The id of Customer
     * @return array       one customer
     */
    public static function getCustomerDetail($id)
    {
        $customers = Customer::where('id', $id)->get();
        return $customers->first();
    }

    /**
     * store a customer
     * @param  integer $id The id of Customer
     * @return void
     */
    public static function storeCustomer($customer)
    {
        $new_customer = new Customer;
        foreach($customer as $key => $value) {
            $new_customer->{$key} = $value;
        }
        $new_customer->save();
        return $new_customer->id;
    }

    /**
     * update a customer
     * @param  integer $id The id of Customer
     * @return void
     */
    public static function updateCustomer($customer, $id)
    {
        $tmp_customer = Customer::find($id);
        foreach($customer as $key => $value) {
            $tmp_customer->{$key} = $value;
        }
        $tmp_customer->save();
    }

    /**
     * delete a customer
     * @param  integer $id The id of Customer
     * @return void
     */
    public static function deleteCustomer($id) {
        $tmp_customer = Customer::find($id);
        $tmp_customer->delete();
    }
}
