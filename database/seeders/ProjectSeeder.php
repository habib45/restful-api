<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->truncate();
        DB::table('projects')->insert([
        [
            'name' => 'Grameenphone Limited',
            'description' => 'Grameenphone Limited',
        ]
        ]); 
    }
}
