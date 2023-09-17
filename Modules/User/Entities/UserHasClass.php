<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHasClass extends Model
{
    use HasFactory;
    protected $table = 'user_has_classes';

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserHasClassFactory::new();
    }
}
