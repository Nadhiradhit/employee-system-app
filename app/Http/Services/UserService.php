<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function list(int $limit = 10, string $keyword = '', string $sortColumn = 'name', string $sortBy = 'desc'): LengthAwarePaginator
    {
        return $this->repository->paginate($limit, $keyword, $sortColumn, $sortBy);
    }

    public function view(string $id): User
    {
        return $this->repository->findOrFail($id);
    }

    public function register(array $validated): User
    {
        $validated['password'] = Hash::make($validated['password']);
        return $this->repository->create($validated);
    }

    public function modify(string $id, array $validated): User
    {
        $user = $this->repository->findOrFail($id);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        return $this->repository->update($user, $validated);
    }

    public function remove(string $id): void
    {
        $user = $this->repository->findOrFail($id);
        $this->repository->delete($user);
    }
}
