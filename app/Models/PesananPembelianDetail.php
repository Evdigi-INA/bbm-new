<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananPembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pesanan_pembelian_detail';

    // protected $with = ['barang'];

    protected $fillable = [
        'pesanan_pembelian_id',
        'barang_id',
        'qty',
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

    public function pesanan_pembelian()
    {
        return $this->belongsTo(PesananPembelian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
