<?php

namespace Modules\Room\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Live extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\LiveFactory::new();
    }

    //  === relations === //
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'live_id');
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

    //  how to register object function -> keyword scope 
    // test case 
    public function scopeSearch($query, $q, $role) // naming lowerCase // 
    {
        MethodsHelpers::search($query, $q, $role);
    }
}
