<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekGiroCair extends Model
{
    use HasFactory;

    protected $table = 'cek_giro_cair';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'cek_giro_id',
        'dicairkan_ke',
        'bank_id',
        'rekening_bank_id',
        'keterangan',
    ];

    public function cek_giro()
    {
        return $this->belongsTo(CekGiro::class);
    }

    public function rekening()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
