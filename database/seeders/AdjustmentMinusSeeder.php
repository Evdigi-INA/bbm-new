<?php

namespace Database\Seeders;

use App\Models\AdjustmentMinus;
use App\Models\AdjustmentMinusDetail;
use Illuminate\Database\Seeder;

class AdjustmentMinusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adjusmentMinus = AdjustmentMinus::create([
            'kode' => 'ADJMN-' . now()->format('Ym') . '00001',
            'tanggal' => today(),
            'gudang_id' => 1,
        ]);

        $adjusmentDetail = [];
        $adjusmentDetail[] = new AdjustmentMinusDetail([
            'barang_id' => 1,
            'supplier_id' => 1,
            'bentuk_kepemilikan_stok' => 'Stok Sendiri',
            'qty' => 10
        ]);

        $adjusmentDetail[] = new AdjustmentMinusDetail([
            'barang_id' => 2,
            'supplier_id' => 2,
            'bentuk_kepemilikan_stok' => 'Stok Sendiri',
            'qty' => 2
        ]);

        $adjusmentMinus->adjustment_minus_detail()->saveMany($adjusmentDetail);
    }
}
