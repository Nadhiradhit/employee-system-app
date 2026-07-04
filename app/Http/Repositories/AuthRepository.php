<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use OwenIt\Auditing\Models\Audit;

class UserRepository
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return User::with('employee')->latest()->paginate($perPage);
    }

    public function findOrFail(string $id): User
    {
        return User::with('employee')->findOrFail($id);
    }

    public function create(array $attributes): User
    {
        $user = User::create($attributes);

        return $user;
    }

    public function update(User $user, array $attributes): User
    {
        $user->update($attributes);
        return $user->fresh('employee');
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
