<?php

namespace Database\Seeders;

use App\Models\Toko;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Toko::create([
            'nama' => 'LC KOMPUTER',
            'telp1' => '0215456456',
            'telp2' => '0814564562',
            'email' => 'lc-komputer@gmail.com',
            'deskripsi' => 'Your Friendly Supplier',
            'npwp' => '',
            'fax' => '',
            'nppkp' => '',
            'website' => '',
            'tgl_pkp' => now(),
            'alamat' => 'JL. Mangga Dua Raya Harco M2 Lt.3 Blok A 22',
            'kota' => 'Jakarta',
            'kode_pos' => '',
        ]);
    }
}
