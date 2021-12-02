<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SatuanBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('satuan_barang')->insert(
            [
                [
                    'kode' => 'pcs',
                    'nama' => 'Pieces',
                    'status' => 'Y',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'kode' => 'set',
                    'nama' => 'SET',
                    'status' => 'Y',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
