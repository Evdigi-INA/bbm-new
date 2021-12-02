<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentPlus extends Model
{
    use HasFactory;

    protected $table = 'adjustment_plus';

    protected $fillable = [
        'kode',
        'tanggal',
        'gudang_id',
        'matauang_id',
        'rate',
        'grand_total'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function adjustment_plus_detail()
    {
        return $this->hasMany(AdjustmentPlusDetail::class);
    }

    public function matauang()
    {
        return $this->belongsTo(Matauang::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
