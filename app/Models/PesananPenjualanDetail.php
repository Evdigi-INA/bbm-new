<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananPenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'pesanan_penjualan_detail';

    // protected $with = ['barang'];

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'pesanan_penjualan_id',
        'barang_id',
        'qty',
        'harga',
        'diskon_persen',
        'diskon',
        'ppn',
        'gross',
        'netto'
    ];

    public function pesanan_penjualan()
    {
        return $this->belongsTo(PesananPenjualan::class, 'pesanan_penjualan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
