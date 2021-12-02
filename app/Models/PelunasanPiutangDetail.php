<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelunasanPiutangDetail extends Model
{
    use HasFactory;

    protected $table = 'pelunasan_piutang_detail';

    protected $fillable = [
        'penjualan_id',
        'pelunasan_piutang_id'
    ];

    public function pelunasan_piutang()
    {
        return $this->belongsTo(PelunasanPiutang::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
