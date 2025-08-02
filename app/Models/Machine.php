<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'wh_id', 'code', 'name', 'type', 'location', 'status'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'wh_id');
    }
}
