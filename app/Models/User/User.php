<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User\Type;
use App\Models\Regulator\Regulator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | BelongsTo
    |--------------------------------------------------------------------------
    |
    | Table users belongsto users_type depends on field type_id
    |
    |--------------------------------------------------------------------------
    | Noted:
    |--------------------------------------------------------------------------
    |
    | $this->belongsTo(Parent::class,'foreign_key','owner_key');
    |
    */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id','id');
    }

    //============>> Regulator
    public function regulator(): BelongsTo
    {
        return $this->belongsTo(Regulator::class, 'regulator_id','id');
    }
}
