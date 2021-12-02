<?php

namespace Database\Seeders;

use App\Models\AdjustmentPlus;
use App\Models\AdjustmentPlusDetail;
use Illuminate\Database\Seeder;

class AdjustmentPlusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adjusmentPlus = AdjustmentPlus::create([
            'kode' => 'ADJPL-' . now()->format('Ym') . '00001',
            'tanggal' => today(),
            'matauang_id' => 1,
            'gudang_id' => 1,
            'rate' => 2,
            'grand_total' => 8000,
        ]);

        $adjusmentDetail = [];
        $adjusmentDetail[] = new AdjustmentPlusDetail([
            'barang_id' => 1,
            'supplier_id' => 1,
            'bentuk_kepemilikan_stok' => 'Stok Sendiri',
            'harga' => 1000,
            'qty' => 3,
            'subtotal' => 3000,
        ]);

        $adjusmentDetail[] = new AdjustmentPlusDetail([
            'barang_id' => 2,
            'supplier_id' => 2,
            'bentuk_kepemilikan_stok' => 'Stok Sendiri',
            'harga' => 2500,
            'qty' => 2,
            'subtotal' => 5000,
        ]);

        $adjusmentPlus->adjustment_plus_detail()->saveMany($adjusmentDetail);
    }
}
