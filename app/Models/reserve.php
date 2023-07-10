<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'consultation_id',
        'date',
        'place',
        'person_id',
        'period',
        'person_expert_id',
    ];

    public function consultations() : BelongsTo
    {
        return $this->belongsTo(Consultations::class,'consultation_id');
    }
}
