<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekGiro extends Model
{
    use HasFactory;

    protected $table = 'cek_giro';

    protected $fillable = [
        'pembelian_id',
        'penjualan_id',
        'jenis_cek',
        'status',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function pencairan_cek()
    {
        return $this->hasOne(CekGiroCair::class);
    }

    public function tolak_cek()
    {
        return $this->hasOne(CekGiroTolak::class);
    }
}
