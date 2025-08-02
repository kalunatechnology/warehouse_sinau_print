<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineCounter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'machine_id',
        'counter',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
