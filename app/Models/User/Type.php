<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;
    protected $table = 'users_type';

    /*
    |--------------------------------------------------------------------------
    | One-To-Many relationship
    |--------------------------------------------------------------------------
    |
    | Also known as the hasMany-relationship, this relationship 
    | defines a relation that 'one type has many other users.
    | Say that a type has many users
    |
    |--------------------------------------------------------------------------
    | Noted:
    |--------------------------------------------------------------------------
    |
    | this->hasOne('Child::class', 'foreign_key', 'local_key');
    | local_key is the primary key of table users_type. We only need to specify it if your primary key is not called id
    |
    */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tyep_id');
    }
}
