<?php

namespace Modules\Instructor\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Instructor\Database\factories\InstructorFactory::new();
    }

    // === scope === //

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

     public function scopeTrash($query, $is_trash)
     {
        MethodsHelpers::trashData($query, $is_trash);
     }
}
