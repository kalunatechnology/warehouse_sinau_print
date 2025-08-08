<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'wh_id',
        'm_id',
        'qty',
        'type',
        'price',
        'date',
        'user_id'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'wh_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'm_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}