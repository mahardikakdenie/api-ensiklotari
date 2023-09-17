<?php

namespace Modules\Room\Entities;

use App\Http\Helpers\MethodsHelpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Category\Entities\Category;
use Modules\Media\Entities\Media;
use Modules\Studio\Entities\Studio;

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

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }

    public function instructor()
    {
        return $this->hasMany(InstructorHasClass::class, 'live_class_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function preview()
    {
        return $this->hasOne(UrlPreview::class, 'live_class_id');
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class, 'live_class_id');
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

    public function scopeWhereWithEntities($query, $entities, $field, $value)
    {
        MethodsHelpers::whereWithEntities($query, $entities, $field, $value);
    }

    public function scopeSummary($query, $summary)
    {
        if ($summary === 'publish' || $summary === 'draft' || $summary === 'suspend' || $summary === 'deleted') {
            if ($summary === 'deleted') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $summary);
            }
        }
        if ($summary === 'active') {
            $query->where('is_active', true);
        }
        if ($summary === 'non-active') {
            $query->where('is_active', false);
        }
        if ($summary === 'new') {
            $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        }

        return $query;
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
}
