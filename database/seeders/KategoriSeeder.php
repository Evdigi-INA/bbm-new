<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'kode' => 'SBN',
            'nama' => 'Sabun',
            'status' => 'Y'
        ]);

        Kategori::create([
            'kode' => 'IDM',
            'nama' => 'Indomie',
            'status' => 'Y'
        ]);
    }
}
