<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;


class Employee extends Model
{

    use HasFactory;

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

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }
}
