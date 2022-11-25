<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
            'api_apps_id' => 1,
            'username' => 'cht_user@grameenphone.com',
            'password' => Hash::make('password'),
            'name' => 'DWE-Admin',
            'email' => 'cht_user@grameenphone.com',
            'mobile' => '+8801747006944',
            'designation' => 'Admins',
            'status' => 'Active',
            'sys_user' => '1',
            'created_by' => '1'
        ]);
    }
}
