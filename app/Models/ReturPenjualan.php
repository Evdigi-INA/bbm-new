<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualan extends Model
{
    use HasFactory;

    protected $table = 'retur_penjualan';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'penjualan_id',
        'kode',
        'tanggal',
        'gudang_id',
        'rate',
        'keterangan',
        'subtotal',
        'total_ppn',
        'total_gross',
        'total_diskon',
        'total_netto',
    ];

    public function retur_penjualan_detail()
    {
        return $this->hasMany(ReturPenjualanDetail::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(penjualan::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
