<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekGiroTolak extends Model
{
    use HasFactory;

    protected $table = 'cek_giro_tolak';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'cek_giro_id',
        'keterangan',
    ];

    public function cek_giro()
    {
        return $this->belongsTo(CekGiro::class);
    }
}
