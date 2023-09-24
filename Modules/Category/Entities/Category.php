<?php

namespace Modules\Category\Entities;

use App\Http\Helpers\MethodsHelpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Entities\Media;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
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

    public function scopeSummary($query, $summary)
    {
        if ($summary === 'publish' || $summary === 'draft') return $query->where('status', $summary);
        if ($summary === 'new') return $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        else return $query;
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
