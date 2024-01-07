<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Suppliers')->insert([
            'nama' => 'Supplier 1'
        ]);
        DB::table('Suppliers')->insert([
            'nama' => 'Supplier 2'
        ]);
        DB::table('Suppliers')->insert([
            'nama' => 'Supplier 3'
        ]);
    }
}
