<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class avaible_time extends Model
{
    use HasFactory;

    protected $fillable=[
        'expert_id',
        'day',
        'time',
        'period'
    ];

    public function people() : BelongsTo
    {
        return $this->belongsTo(Person::class,'expert_id');
    }
}
