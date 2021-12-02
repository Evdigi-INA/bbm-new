<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'pesanan_penjualan_id',
        'matauang_id',
        'pelanggan_id',
        'salesman_id',
        'gudang_id',
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

    public function pesanan_penjualan()
    {
        return $this->belongsTo(PesananPenjualan::class);
    }

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function penjualan_pembayaran()
    {
        return $this->hasMany(PenjualanPembayaran::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function matauang()
    {
        return $this->belongsTo(Matauang::class);
    }

    public function salesman()
    {
        return $this->belongsTo(Salesman::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function pelunasan_piutang()
    {
        return $this->hasOne(PelunasanPiutang::class);
    }

    public function cek_giro()
    {
        return $this->hasMany(CekGiro::class);
    }

    public function retur_penjualan()
    {
        return $this->hasOne(ReturPenjualan::class);
    }
}
