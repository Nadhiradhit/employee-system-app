<?php

namespace App\Http\Services;

use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeeServices
{

    public function createEmployee(array $data)
    {
        $employee = Employee::create([
            'user_id' => $data['user_id'],
            'phone_number' => $data['phone_number'],
            'department' => $data['department'],
            'joining_date' => $data['joining_date'],
            'status' => $data['status'],
        ]);

        return $employee;
    }

    public function getEmployee()
    {
        $employee = Employee::paginate(10);

        return $employee;
    }

    public function getEmployeeById($userId)
    {
        return Employee::where('user_id', $userId)->firstOrFail();
    }

    public function updateEmployee(array $data, $userId)
    {
        $employee = Employee::where('user_id', $userId)->firstOrFail();
        $employee->update($data);

        return $employee;
    }

    public function deleteEmployee($userId)
    {
        $employee = Employee::where('user_id', $userId)->firstOrFail();
        $employee->delete();
    }
}
