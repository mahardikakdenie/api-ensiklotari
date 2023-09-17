<?php

namespace Modules\Dashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $table = "banners";

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Dashboard\Database\factories\BannerFactory::new();
    }
}
