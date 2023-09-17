<?php

namespace Modules\Role\Entities;

use App\Http\Helpers\MethodsHelpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Studio\Entities\Studio;
use Modules\User\Entities\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Role\Database\factories\RoleFactory::new();
    }
    public function scopeEntities($query, $entities)
    {
        MethodsHelpers::entities($query, $entities);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }

    public function role_has_permissions()
    {
        return $this->hasMany(RoleHasPermissions::class, 'role_id');
    }

    public function scopeWhereWithEntities($query, $record, $field, $target)
    {
        MethodsHelpers::whereWithEntities($query, $record, $field, $target);
    }

    public function scopeSummary($query, $summary)
    {
        if ($summary === 'new') {
            return $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        }

        return $query;
    }
}
