<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;


class Employee extends Model implements Auditable
{

    use HasFactory,  AuditableTrait;

    protected $primaryKey = 'id';
    protected $table = 'employee';

    protected $fillable = [
        'user_id',
        'phone_number',
        'department',
        'joining_date',
        'status'
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    protected $auditEvents = [
        'create',
        'update',
        'delete'
    ];


    protected $auditExclude = [
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
