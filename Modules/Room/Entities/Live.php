<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Live extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\LiveFactory::new();
    }

    //  === relations === //
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'live_key');
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
