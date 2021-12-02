<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelunasanHutangDetail extends Model
{
    use HasFactory;

    protected $table = 'pelunasan_hutang_detail';

    protected $fillable = [
        'pelunasan_hutang_id',
        'pembelian_id'
    ];

    public function pelunasan_hutang()
    {
        return $this->belongsTo(PelunasanHutangl::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
