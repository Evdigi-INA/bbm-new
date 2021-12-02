<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'retur_pembelian_detail';

    protected $with = ['barang'];

    protected $fillable = [
        'retur_pembelian_id',
        'barang_id',
        'qty_beli',
        'qty_retur',
        'harga',
        'diskon_persen',
        'diskon',
        'ppn',
        'pph',
        'biaya_masuk',
        'clr_fee',
        'gross',
        'netto'
    ];

    public function retur_pembelian()
    {
        return $this->belongsTo(ReturPembelian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
