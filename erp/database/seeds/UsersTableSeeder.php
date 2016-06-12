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
        DB::table('users')->insert([
            [ //admin帳號
                'id' => '1', 
                'name' => 'admin', 
                'email' => 'admin@admin.com',
                'password' => '$2y$10$4yxyFxrRraGQnS8.M.KtVOcMXGeyVIogfqdBUE.fpmgm/l6R.3cK2'
            ]
        ]);
    }
}
