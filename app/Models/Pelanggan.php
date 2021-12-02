<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'kode',
        'nama_pelanggan',
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
        'status',
        'area_id',
        'limit'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
