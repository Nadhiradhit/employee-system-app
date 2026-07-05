<?php

namespace App\Http\Repositories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class EmployeeRepository
{

    public function paginate(string $keyword = '', int $perPage = 10, string $sortBy = 'desc', string $filterByStatus = '', string $filterByDepartment = '', string $sortColumn = 'name'): LengthAwarePaginator
    {
        $limit = $perPage ?? 10;

        $query = Employee::with('user');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('email', 'like', "%{$keyword}%")
                        ->orWhere('id', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%");
                });
            });
        }

        if ($filterByStatus) {
            $query->where('employee.status', $filterByStatus);
        }

        if ($filterByDepartment) {
            $query->where('employee.department', 'like', '%' . $filterByDepartment . '%');
        }

        if ($sortColumn === 'name') {
            $query->join('users', 'employee.user_id', '=', 'users.id')
                ->select('employee.*')
                ->orderBy('users.name', $sortBy);
        } elseif ($sortColumn === 'joined_date' || $sortColumn === 'joining_date') {
            $query->select('employee.*')->orderBy('employee.joining_date', $sortBy);
        }

        return $query->paginate($limit);
    }

    public function findByUserIdOrFail(string $userId): Employee
    {
        return Employee::with('user')->where('user_id', $userId)->firstOrFail();
    }

    public function create(array $attributes): Employee
    {
        return Employee::create($attributes);
    }

    public function update(Employee $employee, array $attributes): Employee
    {
        $employee->update($attributes);
        return $employee->fresh('user');
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
    }


    public function getUnlinkedUsers(): Collection
    {
        return User::whereDoesntHave('employee')->get();
    }
}
