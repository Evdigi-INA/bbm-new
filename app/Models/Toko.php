<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';

    protected $fillable = [
        'nama',
        'telp1',
        'email',
        'deskripsi',
        'telp2',
        'npwp',
        'fax',
        'nppkp',
        'website',
        'tgl_pkp',
        'alamat',
        'kota',
        'kode_pos',
    ];
}
