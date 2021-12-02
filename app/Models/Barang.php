<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode',
        'nama',
        'jenis',
        'kategori_id',
        'satuan_id',
        'harga_beli_matauang',
        'harga_jual_matauang',
        'harga_beli',
        'harga_jual',
        'harga_jual_min',
        'stok',
        'min_stok',
        'gambar',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan()
    {
        return $this->belongsTo(SatuanBarang::class);
    }

    public function matauang_beli()
    {
        return $this->belongsTo(Matauang::class, 'harga_beli_matauang');
    }

    public function mata_uang_jual()
    {
        return $this->belongsTo(Matauang::class, 'harga_jual_matauang');
    }

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function pesanan_pembelian_detail()
    {
        return $this->hasMany(PesananPembelianDetail::class);
    }

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function retur_penjualan_detail()
    {
        return $this->hasMany(ReturPenjualanDetail::class);
    }

    public function pesanan_penjualan_detail()
    {
        return $this->hasMany(PesananPenjualanDetail::class);
    }

    public function adjustment_plus_detail()
    {
        return $this->hasMany(AdjustmentPlusDetail::class);
    }

    public function adjustment_minus_detail()
    {
        return $this->hasMany(AdjustmentMinusDetail::class);
    }
}
