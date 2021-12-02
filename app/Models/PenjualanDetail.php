<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';

    // protected $with = ['barang'];

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'qty',
        'harga',
        'diskon_persen',
        'diskon',
        'ppn',
        'gross',
        'netto'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
