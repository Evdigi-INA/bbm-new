<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'kode',
        'nama_supplier',
        'npwp',
        'nppkp',
        'tgl_pkp',
        'alamat',
        'kota',
        'kode_pos',
        'telp1',
        'telp2',
        'nama_kontak',
        'telp_kontak',
        'top',
        'status'
    ];
}
