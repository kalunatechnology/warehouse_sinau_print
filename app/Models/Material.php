<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'm_code', 'm_name', 'm_price', 'm_type', 'm_supplier',
        'unit_id', 'unit_detail', 'conversion', 'm_limit', 'waste', 'stock'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
