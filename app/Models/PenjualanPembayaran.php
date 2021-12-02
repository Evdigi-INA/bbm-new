<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPembayaran extends Model
{
    use HasFactory;

    protected $table = 'penjualan_pembayaran';

    protected $fillable = [
        'jenis_pembayaran',
        'penjualan_id',
        'bank_id',
        'rekening_bank_id',
        'tgl_cek_giro',
        'no_cek_giro',
        'bayar'
    ];

    // protected $with = ['bank', 'rekening'];

    protected $casts = ['tgl_cek_giro' => 'date'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function rekening()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id');
    }
}
