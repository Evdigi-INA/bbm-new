<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelunasanPiutang extends Model
{
    use HasFactory;

    protected $table = 'pelunasan_piutang';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'bank_id',
        'rekening_bank_id',
        'kode',
        'tanggal',
        'rate',
        'jenis_pembayaran',
        'no_cek_giro',
        'tgl_cek_giro',
        'bayar',
        'keterangan',
    ];

    public function pelunasan_piutang_detail()
    {
        return $this->hasMany(PelunasanPiutangDetail::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function rekening_bank()
    {
        return $this->belongsTo(RekeningBank::class);
    }
}
