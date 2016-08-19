<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('erp_users')->truncate();
        DB::table('erp_users')->insert([
            [ //superAdmin帳號
                'name' => 'superAdmin',
                'employee_id' => '1001',
                'emp_name' => '超級管理員',
                'email' => 'superAdmin@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '9',
            ],
            [ //admin帳號
                'name' => 'admin',
                'employee_id' => '1002',
                'emp_name' => '系統管理員',
                'email' => 'admin@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '1',
            ],
            [ //一般使用者帳號
                'name' => 'user',
                'employee_id' => '1003',
                'emp_name' => '一般使用者',
                'email' => 'user@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '0',
            ],
            [ //測試使用者帳號
                'name' => 'demo',
                'employee_id' => '1004',
                'emp_name' => '來賓',
                'email' => 'demo@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '-1',
            ],
        ]);
    }
}
