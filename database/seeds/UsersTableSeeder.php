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
                'email' => 'superAdmin@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '9',
            ],
            [ //admin帳號
                'name' => 'admin',
                'email' => 'admin@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '1',
            ],
            [ //一般使用者帳號
                'name' => 'user',
                'email' => 'user@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '1',
            ],
            [ //測試使用者帳號
                'name' => 'demo',
                'email' => 'demo@ezrun.com',
                'password' => bcrypt('073700050'),
                'leavl' => '-1',
            ],
        ]);
    }
}
