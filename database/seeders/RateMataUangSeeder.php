<?php

namespace Database\Seeders;

use App\Models\RateMataUang;
use Illuminate\Database\Seeder;

class RateMataUangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RateMataUang::create([
            'tanggal' => now(),
            'matauang_id' => 2, //Dollar
            'matauang_default' => 1, //Rupiah
            'rate' => '14500'
        ]);
    }
}
