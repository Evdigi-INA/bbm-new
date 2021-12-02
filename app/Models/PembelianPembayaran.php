<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianPembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembelian_pembayaran';

    protected $fillable = [
        'jenis_pembayaran',
        'pembelian_id',
        'bank_id',
        'rekening_bank_id',
        'tgl_cek_giro',
        'no_cek_giro',
        'bayar'
    ];

    // protected $with = ['bank', 'rekening'];

    protected $casts = ['tgl_cek_giro' => 'date'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
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
