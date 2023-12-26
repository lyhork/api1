<?php

namespace App\Models\Survey;

use App\Models\Survey\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;
    protected $table = 'survey_type';

    /*
    |--------------------------------------------------------------------------
    | BelongsTo
    |--------------------------------------------------------------------------
    |
    | Table orders_detail belongsto orders depends on field order_id
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
        return $this->hasMany(Survey::class, 'type_id')
        ->select('*');
    }

    /*
    |--------------------------------------------------------------------------
    | BelongsTo
    |--------------------------------------------------------------------------
    |
    | Table orders_detail belongsto products depends on field product_id
    |
    |--------------------------------------------------------------------------
    | Noted:
    |--------------------------------------------------------------------------
    |
    | $this->belongsTo(Parent::class,'foreign_key','owner_key');
    |
    */
}
