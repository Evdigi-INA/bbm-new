<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gudang::create([
            'kode' => 'GB',
            'nama' => 'Gudang bekasi',
            'status' => 'Y',
            'gudang_penjualan' => 1
        ]);

        Gudang::create([
            'kode' => 'GJ',
            'nama' => 'Gudang jakarta',
            'status' => 'Y',
            'gudang_penjualan' => 1
        ]);
    }
}
