<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MatauangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('matauang')->insert(
            [
                [
                    'kode' => 'Rp.',
                    'nama' => 'Rupiah',
                    'default' => 'Y',
                    'status' => 'Y',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'kode' => '$',
                    'nama' => 'US Dollar',
                    'default' => 'N',
                    'status' => 'Y',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
