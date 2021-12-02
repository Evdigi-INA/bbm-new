<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'kode' => 'BCA',
            'nama' => 'Bank Central Asia(BCA)',
            'status' => 'Y'
        ]);

        Bank::create([
            'kode' => 'MDR',
            'nama' => 'Mandiri',
            'status' => 'Y'
        ]);
    }
}
