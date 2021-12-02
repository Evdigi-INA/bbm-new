<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentMinusDetail extends Model
{
    use HasFactory;

    protected $table = 'adjustment_minus_detail';

    protected $fillable = [
        'adjustment_minus_id',
        'bentuk_kepemilikan_stok',
        'barang_id',
        'supplier_id',
        'qty'
    ];

    // protected $with = ['barang', 'supplier'];

    public function adjustment_minus()
    {
        return $this->belongsTo(AdjustmentMinus::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
