<?php

namespace Modules\Certificate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Studio\Entities\Studio;

class CertificateStudio extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'certificates_studios';

    protected static function newFactory()
    {
        return \Modules\Certificate\Database\factories\CertificateStudioFactory::new();
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }
}
