<?php

namespace Modules\Tutorial\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Tutorial\Database\factories\TutorialFactory::new();
    }

    // scope 
    public function scopeEntities($query, $entities)
    {
        MethodsHelpers::entities($query, $entities);
    }
}
