<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UrlPreview extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\UrlPreviewFactory::new();
    }

    public function live_class()
    {
        return $this->belongsTo(Live::class, 'live_class_id');
    }
}
