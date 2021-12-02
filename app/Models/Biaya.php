<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biaya';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'matauang_id',
        'bank_id',
        'rekening_bank_id',
        'kode',
        'tanggal',
        'jenis_transaksi',
        'kas_bank',
        'keterangan',
        'rate',
        'total',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function matauang()
    {
        return $this->belongsTo(Matauang::class);
    }

    public function rekening()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id');
    }

    public function biaya_detail()
    {
        return $this->hasMany(BiayaDetail::class);
    }
}
