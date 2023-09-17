<?php

namespace Modules\Instructor\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Entities\Media;
use Modules\Studio\Entities\Studio;
use Illuminate\Support\Str;
use Modules\Certificate\Entities\Certificate;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Instructor\Database\factories\InstructorFactory::new();
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }
    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id');
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
    public function scopeWhereWithEntities($query, $record, $field, $target)
    {
        MethodsHelpers::whereWithEntities($query, $record, $field, $target);
    }

    public static function scopeGeneratedSlug($q, $title)
    {
        $new_slug = Str::slug($title);
        $slug_check = $q->where('slug', $new_slug)->count();
        if ($slug_check == 0) {
            $slug = $new_slug;
        } else {
            $check = 0;
            $unique = false;
            while ($unique == false) {
                $inc_id = ++$check;
                $check = $q->where('slug', $new_slug . '-' . $inc_id)->count();
                if ($check > 0) {
                    $unique = false;
                } else {
                    $unique = true;
                }
            }
            $slug = $new_slug . '-' . $inc_id;
        }

        return $slug;
    }

    public function scopeBySlug($query, $slug)
    {
        MethodsHelpers::search($query, $slug, 'slug');
    }
}
