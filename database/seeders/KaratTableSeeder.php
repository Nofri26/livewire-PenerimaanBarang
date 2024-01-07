<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaratTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karat')->insert([
            'parameter' => 'Karat 1'
        ]);
        DB::table('karat')->insert([
            'parameter' => 'Karat 2'
        ]);
        DB::table('karat')->insert([
            'parameter' => 'Karat 3'
        ]);
    }
}
