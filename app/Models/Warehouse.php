<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'branch_name', 'wh_type', 'wh_name', 'address'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
