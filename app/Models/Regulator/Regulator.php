<?php

namespace App\Models\Regulator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey\Survey;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regulator extends Model
{
    use HasFactory;
    protected $table = 'regulators';

    /*
    |--------------------------------------------------------------------------
    | BelongsTo
    |--------------------------------------------------------------------------
    |
    | Table products belongsto products_type depends on field type_id
    |
    |--------------------------------------------------------------------------
    | Noted:
    |--------------------------------------------------------------------------
    |
    | $this->belongsTo(Parent::class,'foreign_key','owner_key');
    |
    */
    public function surveys(): HasMany
    { // 1:M
        return $this->hasMany(Survey::class, 'regulator_id')
        ->select('*');
    }

    //=============>> User
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'regulator_id');
    }
}
