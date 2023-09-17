<?php

namespace Modules\Tutorial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorialContents extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'tutorial_contents';

    
    protected static function newFactory()
    {
        return \Modules\Tutorial\Database\factories\TutorialContentsFactory::new();
    }
}
