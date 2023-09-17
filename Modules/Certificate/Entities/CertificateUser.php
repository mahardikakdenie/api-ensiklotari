<?php

namespace Modules\Certificate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateUser extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'certificate_studios'
    
    protected static function newFactory()
    {
        return \Modules\Certificate\Database\factories\CertificateUserFactory::new();
    }
}
