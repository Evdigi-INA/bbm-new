<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerakitanPaket extends Model
{
    use HasFactory;

    protected $table = 'perakitan_paket';

    protected $fillable = [
        'kode',
        'tanggal',
        'gudang_id',
        'paket_id',
        'kuantitas',
        'keterangan'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function perakitan_paket_detail()
    {
        return $this->hasMany(PerakitanPaketDetail::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function paket()
    {
        return $this->belongsTo(Barang::class, 'paket_id');
    }
}
