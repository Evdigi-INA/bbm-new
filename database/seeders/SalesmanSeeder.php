<?php

namespace Database\Seeders;

use App\Models\Salesman;
use Illuminate\Database\Seeder;

class SalesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salesman::create([
            'user_id' => 2,
            'kode' => 'AMD',
            'nama' => 'Amanada',
            'commission' => '1',
            'status' => 'Y'
        ]);

        Salesman::create([
            'kode' => 'EDW',
            'nama' => 'Edward',
            'commission' => '1',
            'status' => 'Y'
        ]);
    }
}
