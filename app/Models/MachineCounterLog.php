<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineCounterLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'machine_id',
        'counter_before',
        'counter_after',
        'changed_by',
        'description',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
