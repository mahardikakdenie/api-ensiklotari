<?php

namespace Modules\Gallery\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Entities\Media;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];

    protected static function newFactory()
    {
        return \Modules\Gallery\Database\factories\GalleryFactory::new();
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
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

    public function scopeTrash($query, $is_trash)
    {
        MethodsHelpers::trashData($query, $is_trash);
    }
}
