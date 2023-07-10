<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultations extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'content',
        'cost',
        'rate',
        'Specialises',
        'person_id',
        'isfinished',
        'person_expert_id'
    ];

    public function people() : BelongsTo
    {
        return $this->belongsTo(Person::class,'person_id');
    }

    public function people_expert() : BelongsTo
    {
        return $this->belongsTo(Person::class,'person_expert_id');
    }

    // public function expereince() : BelongsTo
    // {
    //     return $this->belongsTo(expereince::class,'person_expert_id');
    // }

    public function reserves() : HasMany
    {
        return $this->hasMany(reserve::class,'consultation_id');
    }
}
