<?php

namespace Modules\HomePage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $table="banners";

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\HomePage\Database\factories\BannerFactory::new();
    }
}
