<?php

namespace Modules\Role\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionHasSubPermission extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'permission_has_sub_permission';

    protected static function newFactory()
    {
        return \Modules\Role\Database\factories\PermissionHasSubPermissionFactory::new();
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function sub_permission()
    {
        return $this->belongsTo(SubPermission::class, 'sub_permission_id');
    }
}
