<?php

namespace App\Models\Survey;

use App\Models\Regulator\Regulator;
use App\Models\Survey\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    use HasFactory;
    protected $table = 'survey';

    public function regulator(): BelongsTo
    { // M:1
        return $this->belongsTo(Regulator::class, 'regulator_id')->select('id', 'name');
    }

    public function type(): BelongsTo
    { // M:1
        return $this->belongsTo(Type::class, 'type_id')->select('id', 'name');
    }

}
