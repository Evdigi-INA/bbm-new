<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';

    // protected $with = ['barang'];

    protected $fillable = [
        'pembelian_id',
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

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
