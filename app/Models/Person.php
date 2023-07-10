<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Person extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'img_bath',
        'country',
        'city',
        'email',
        'password',
        'gender',
        'birth_date',
        'favourites',
        'expert_id'
    ];

    public function expereince() : BelongsTo
    {
        return $this->belongsTo(expereince::class,'expert_id');
    }

    public function wallet() : HasOne
    {
        return $this->hasOne(wallet::class,'owner_wallet_id');
    }

    public function phones() : HasMany
    {
        return $this->hasMany(phone::class,'owner_phone_id');
    }

    public function Consultations() : HasMany
    {
        return $this->hasMany(Consultations::class,'person_id');
    }

    public function Consultations_expert() : HasMany
    {
        return $this->hasMany(Consultations::class,'person_expert_id');
    }

    public function avaible_time() : HasMany
    {
        return $this->hasMany(avaible_time::class,'expert_id');
    }
}
