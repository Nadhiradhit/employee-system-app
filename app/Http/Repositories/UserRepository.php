<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function paginate(int $limit = 10, string $keyword = '', string $sortColumn = 'name', string $sortBy = 'desc'): LengthAwarePaginator
    {
        $query = User::query();

        $query->with('employee')->latest();

        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        }

        if ($sortColumn === 'name') {
            $query->orderBy('name', $sortBy);
        } elseif ($sortColumn === 'created_at') {
            $query->orderBy('created_at', $sortBy);
        }

        return $query->paginate($limit);
    }

    public function findOrFail(string $id): User
    {
        return User::with('employee')->findOrFail($id);
    }

    public function create(array $attributes): User
    {
        return User::create($attributes);
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
