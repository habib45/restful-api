<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->truncate();
        DB::table('channels')->insert([
        [
            'track_id' => 1,
            'name' => 'MyGp Enterprise',
            'namespace' => 'MyGpEnterprise',
            'description' => 'Module Of My GP',
            'status'=>'Active',
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
        ], 
        [
            'track_id' => 1,
            'name' => 'CIM',
            'namespace' => 'CIM',
            'description' => 'Module Of My GP',
            'status'=>'Active',
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
        ],     
        [
            'track_id' => 1,
            'name' => 'DMS',
            'namespace' => 'DMS',
            'description' => 'Module Of My GP',
            'status'=>'Active',
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
        ]
    ]);
    }
}
