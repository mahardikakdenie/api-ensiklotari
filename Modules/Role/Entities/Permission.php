<?php

namespace Modules\Role\Entities;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Role\Database\factories\PermissionFactory::new();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function sub_permission()
    {
        return $this->hasMany(SubPermission::class, 'permission_id');
    }

    public function permission_has_sub_permission()
    {
        return $this->hasMany(PermissionHasSubPermission::class, 'permission_id');
    }

    public function scopeEntities($query, $entities)
    {
        MethodsHelpers::entities($query, $entities);
    }

    public static function scopeGeneratedSlug($q, $title)
    {
        $new_slug = Str::slug($title);
        $slug_check = $q->where('name', $new_slug)->count();
        if ($slug_check == 0) {
            $slug = $new_slug;
        } else {
            $check = 0;
            $unique = false;
            while ($unique == false) {
                $inc_id = ++$check;
                $check = $q->where('name', $new_slug . '-' . $inc_id)->count();
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
