<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananPenjualan extends Model
{
    use HasFactory;

    protected $table = 'pesanan_penjualan';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'matauang_id',
        'pelanggan_id',
        'rate',
        'bentuk_kepemilikan_stok',
        'keterangan',
        'alamat',
        'subtotal',
        'total_diskon',
        'total_gross',
        'total_ppn',
        'total_biaya_kirim',
        'total_netto',
        'total_netto ',
        'total_penjualan',
        'status'
    ];

    public function pesanan_penjualan_detail()
    {
        return $this->hasMany(PesananPenjualanDetail::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function matauang()
    {
        return $this->belongsTo(Matauang::class);
    }

    // public function salesman()
    // {
    //     return $this->belongsTo(Salesman::class);
    // }

    // public function gudang()
    // {
    //     return $this->belongsTo(Gudang::class);
    // }
}
