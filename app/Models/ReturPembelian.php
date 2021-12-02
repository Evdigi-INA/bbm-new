<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    use HasFactory;

    protected $table = 'retur_pembelian';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'pembelian_id',
        'gudang_id',
        'rate',
        'keterangan',
        'subtotal',
        'total_ppn',
        'total_pph',
        'total_gross',
        'total_diskon',
        'total_clr_fee',
        'total_biaya_masuk',
        'total_netto',
    ];

    public function retur_pembelian_detail()
    {
        return $this->hasMany(ReturPembelianDetail::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
