<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaDetail extends Model
{
    use HasFactory;

    protected $table = 'biaya_detail';

    protected $fillable = [
        'biaya_id',
        'jumlah',
        'deskripsi'
    ];

    public function biaya()
    {
        return $this->belongsTo(Biaya::class);
    }
}
