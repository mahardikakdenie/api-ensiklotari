<?php

namespace Modules\Role\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleHasPermissions extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'role_has_permissions';

    protected static function newFactory()
    {
        return \Modules\Role\Database\factories\RoleHasPermissionsFactory::new();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
