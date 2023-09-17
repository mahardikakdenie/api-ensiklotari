<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Role\Entities\Role;
use \App\Http\Helpers\MethodsHelpers;
use Carbon\Carbon;
use Mockery\Generator\Method;
use Modules\Media\Entities\Media;
use Modules\Studio\Entities\Studio;
use PhpParser\Node\Stmt\Break_;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function studio()
    {
        return $this->hasOne(Studio::class, 'owner_id');
    }

    public function baseCamp()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function has_class()
    {
        return $this->hasMany(UserHasClass::class, 'user_id');
    }

    //  === Scope === //

    public function scopeSummary($query, $summary)
    {
        switch ($summary) {
            case 'active':
                $query->where('is_active', true);
                break;

            case 'non_active':
                $query->where('is_active', false)->orWhere('is_active', null);
                break;
            case 'new':
                $query->whereDate('created_at', '=', Carbon::today()->toDateString());
                break;
            default:
                return $query;
                break;
        }
    }

    public function scopeEntities($query, $entities)
    {
        MethodsHelpers::entities($query, $entities);
    }

    public function scopeOrder($query, $order)
    {
        MethodsHelpers::order($query, $order);
    }

    public function scopeDataLimit($query, $limit)
    {
        MethodsHelpers::limit($query, $limit);
    }

    public function scopeWhereWithEntities($query, $record, $field, $target)
    {
        MethodsHelpers::whereWithEntities($query, $record, $field, $target);
    }
}
