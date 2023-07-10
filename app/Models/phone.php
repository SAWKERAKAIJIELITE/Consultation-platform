<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'phone',
        'owner_phone_id'
    ];

    public function people() :BelongsTo
    {
        return $this->belongsTo(Person::class,'owner_phone_id') ;
    }
}
