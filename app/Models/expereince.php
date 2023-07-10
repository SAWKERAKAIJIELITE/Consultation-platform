<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class expereince extends Model
{
    use HasFactory;

    protected $fillable = [
        'expert_id',
        'Specialises',
        'Experience',
        'min',
        'max',
        'rate',
        'times'
    ];

    public function person() : HasOne
    {
        return $this->hasOne(Person::class,'expert_id');
    }
}
