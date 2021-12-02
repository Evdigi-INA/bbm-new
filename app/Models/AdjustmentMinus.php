<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentMinus extends Model
{
    use HasFactory;

    protected $table = 'adjustment_minus';

    protected $fillable = [
        'kode',
        'tanggal',
        'gudang_id'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function adjustment_minus_detail()
    {
        return $this->hasMany(AdjustmentMinusDetail::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
