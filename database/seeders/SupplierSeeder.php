<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Supplier::create([
        //     'kode' => 'NOSP',
        //     'nama_supplier' => 'Tanpa Supplier',
        //     'npwp' => '',
        //     'nppkp' => '',
        //     'tgl_pkp' => now(),
        //     'alamat' => '',
        //     'kota' => '',
        //     'kode_pos' => '',
        //     'telp1' => '',
        //     'telp2' => '',
        //     'nama_kontak' => '',
        //     'telp_kontak' => '',
        //     'top' => null,
        //     'status' => 'Y',
        // ]);

        Supplier::create([
            'kode' => 'SP1',
            'nama_supplier' => 'Jonathan Joestar',
            'npwp' => '34539053455345',
            'nppkp' => '23487897898',
            'tgl_pkp' => now(),
            'alamat' => 'Jln maju kena mundur kena',
            'kota' => 'bekasi',
            'kode_pos' => '1123',
            'telp1' => '',
            'telp2' => '',
            'nama_kontak' => '',
            'telp_kontak' => '',
            'top' => 7889,
            'status' => 'Y',
        ]);

        Supplier::create([
            'kode' => 'SP2',
            'nama_supplier' => 'Bruno Bucciarati',
            'npwp' => '68789789',
            'nppkp' => '2423423',
            'tgl_pkp' => now(),
            'alamat' => 'Jln passione',
            'kota' => 'Bandung',
            'kode_pos' => '789',
            'telp1' => '',
            'telp2' => '',
            'nama_kontak' => '',
            'telp_kontak' => '',
            'top' => 100,
            'status' => 'Y',
        ]);
    }
}
