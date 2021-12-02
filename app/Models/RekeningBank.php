<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningBank extends Model
{
    use HasFactory;

    protected $table = 'rekening_bank';

    protected $fillable = [
        'kode',
        'nama_rekening',
        'nomor_rekening',
        'bank_id',
        'status'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
