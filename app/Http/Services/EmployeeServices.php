<?php

namespace App\Http\Services;

use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeeServices
{

    public function createEmployee(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $employee = Employee::create([
            'user_id' => $validate['user_id'],
            'phone_number' => $validate['phone_number'],
            'department' => $validate['department'],
            'joining_date' => $validate['joining_date'],
            'status' => $validate['status'],
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

    public function updateEmployee(Request $request, $userId)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $employee = Employee::where('user_id', $userId)->firstOrFail();
        $employee->update($validate);

        return $employee;
    }

    public function deleteEmployee($userId)
    {
        $employee = Employee::where('user_id', $userId)->firstOrFail();
        $employee->delete();
    }
}
