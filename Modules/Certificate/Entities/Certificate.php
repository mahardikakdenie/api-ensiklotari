<?php

namespace Modules\Certificate\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Studio\Entities\Studio;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Certificate\Database\factories\CertificateFactory::new();
    }

    public function pivot_certificate_studio()
    {
        return $this->hasOne(CertificateStudio::class, 'certificate_id');
    }
    // Scope //
    public function scopeEntities($query, $entities)
    {
        MethodsHelpers::entities($query, $entities);
    }
    public function scopeSearchModules($query, $module)
    {
        MethodsHelpers::search($query, $module, 'module');
    }
    public function scopeSearchSlug($query, $slug)
    {
        MethodsHelpers::search($query, $slug, 'slug');
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
}
