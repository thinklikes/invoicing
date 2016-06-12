<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->truncate();
        //用模型工廠隨機填入五十筆客戶
        factory(App\Customer::class, 50)->create();
        // DB::table('customers')->insert([
        //     [
        //         'name'          => '好好客戶',
        //         'shortName'     => '好客戶',
        //         'boss'          => 'boss',
        //         'contactPerson' => 'manager',
        //         'zip'           => '932',
        //         'address'       => 'address1',
        //         'email'         => 'admin@admin.com',
        //         'telphone'      => 'telphone1',
        //         'cellphone'     => 'cellphone1',
        //         'fax'           => 'fax1',
        //         'taxNumber'     => '12345678',
        //     ],
        // ]);
    }
}
