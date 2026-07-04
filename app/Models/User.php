<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;


class User extends Authenticatable implements Auditable
{

    use HasFactory, Notifiable, HasApiTokens, HasUuids, AuditableTrait;

    protected $keyType = 'string';
    protected $table = 'users';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $auditEvents = [
        'create',
        'update',
        'delete'
    ];

    protected $auditExclude = [
        'password'
    ];

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function transformAudit(array $data): array
    {
        if (empty($data['user_id'])) {
            $data['user_id'] = Auth::id() ?? $this->user_id;
        }

        if (Auth::check() && Auth::id() == $data['user_id']) {

            $authUser = Auth::user();
            $data['user_type'] = $authUser->is_admin ? 'admin' : 'user';
        } elseif (!empty($data['user_id'])) {
            $user = User::find($data['user_id']);
            $data['user_type'] = $user && $user->is_admin ? 'admin' : 'user';
        } else {
            $data['user_type'] = 'user';
        }

        return $data;
    }
}
