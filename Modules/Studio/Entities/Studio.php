<?php

namespace Modules\Studio\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class studio extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Studio\Database\factories\StudioFactory::new();
    }


    //  === Scope === //

    public function scopeEntities($query, $entities)
    {
        MethodsHelpers::entities($query, $entities);
    }

    public function scopeOrder($query, $order)
    {
        MethodsHelpers::order($query, $order);
    }

    public function scopeDataLimit($query, $limit)
    {
        MethodsHelpers::limit($query, $limit);
    }
}
