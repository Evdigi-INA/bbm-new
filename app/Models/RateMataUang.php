<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateMataUang extends Model
{
    use HasFactory;

    protected $table = "rate_matauang";

    protected $fillable = [
        "tanggal",
        "matauang_id",
        "matauang_default",
        "rate"
    ];

    public function matauang_asing()
    {
        return $this->belongsTo(Matauang::class, 'matauang_id', 'id');
    }

    public function mata_uang_default()
    {
        return $this->belongsTo(Matauang::class, 'matauang_default', 'id');
    }
}
