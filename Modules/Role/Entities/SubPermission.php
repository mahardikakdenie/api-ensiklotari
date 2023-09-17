<?php

namespace Modules\Role\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubPermission extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = "sub_permissions";

    protected static function newFactory()
    {
        return \Modules\Role\Database\factories\SubPermissionFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
