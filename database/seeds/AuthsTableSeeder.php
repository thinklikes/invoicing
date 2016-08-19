<?php

use Illuminate\Database\Seeder;

class AuthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先清空
        DB::table('erp_auths')->truncate();

        DB::table('erp_auths')->insert([
            [
                'level'   => '9',
                'code'    => 'superAdmin',
                'comment' => '超級管理員',
            ],
            [
                'level'   => '1',
                'code'    => 'admin',
                'comment' => '系統管理員',
            ],
            [
                'level'   => '0',
                'code'    => 'user',
                'comment' => '一般使用者',
            ],
            [
                'level'   => '-1',
                'code'    => 'demo',
                'comment' => '來賓',
            ],
        ]);
    }
}
