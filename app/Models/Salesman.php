<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman extends Model
{
    use HasFactory;

    protected $table = 'salesman';

    protected $fillable = [
        'kode',
        'nama',
        'status',
        'commission',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
