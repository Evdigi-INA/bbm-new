<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matauang extends Model
{
    use HasFactory;
    protected $table = "matauang";

    protected $fillable = [
        'kode',
        'nama',
        'default',
        'status',
    ];
}
