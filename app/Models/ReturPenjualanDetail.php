<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'retur_penjualan_detail';

    protected $with = ['barang'];

    protected $fillable = [
        'retur_penjualan_id',
        'barang_id',
        'qty_beli',
        'qty_retur',
        'harga',
        'diskon_persen',
        'diskon',
        'ppn',
        'gross',
        'netto',
    ];

    public function retur_penjualan()
    {
        return $this->belongsTo(ReturPenjualan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
