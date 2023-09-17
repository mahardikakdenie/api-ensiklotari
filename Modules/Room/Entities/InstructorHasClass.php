<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class InstructorHasClass extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'instructor_has_class';

    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\InstructorHasClassFactory::new();
    }

    public function profile()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
