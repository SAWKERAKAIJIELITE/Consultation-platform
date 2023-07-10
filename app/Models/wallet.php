<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_num',
        'owner_wallet_id',
        'password',
        'wallet_value'
    ];

    public function people() : BelongsTo
    {
        return $this->belongsTo(Person::class,'owner_wallet_id') ;
    }
}
