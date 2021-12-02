<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerakitanPaketDetail extends Model
{
    use HasFactory;

    protected $table = 'perakitan_paket_detail';

    protected $fillable = [
        'perakitan_paket_id',
        'bentuk_kepemilikan_stok',
        'barang_id',
        'qty'
    ];

    // protected $with = ['barang'];

    public function perakitan_paket()
    {
        return $this->belongsTo(AdjustmentMinus::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
