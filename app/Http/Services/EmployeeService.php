<?php

namespace App\Http\Services;

use App\Http\Repositories\EmployeeRepository;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EmployeeService
{
    public function __construct(private EmployeeRepository $repository) {}

    public function list(string $keyword = '', int $limit = 10, string $sortBy = 'desc', string $filterByStatus = '', string $filterByDepartment = '', string $sortColumn = 'name'): LengthAwarePaginator
    {
        return $this->repository->paginate($keyword, $limit, $sortBy, $filterByStatus, $filterByDepartment, $sortColumn);
    }

    public function view(string $userId): Employee
    {
        return $this->repository->findByUserIdOrFail($userId);
    }

    public function register(array $validated): Employee
    {
        return $this->repository->create($validated);
    }

    public function modify(string $userId, array $validated): Employee
    {
        $employee = $this->repository->findByUserIdOrFail($userId);
        return $this->repository->update($employee, $validated);
    }

    public function remove(string $userId): void
    {
        $employee = $this->repository->findByUserIdOrFail($userId);
        $this->repository->delete($employee);
    }

    public function getUnlinkedUsers(): Collection
    {
        return $this->repository->getUnlinkedUsers();
    }
}
