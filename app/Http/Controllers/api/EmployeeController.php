<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Services\EmployeeServices;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ApiResponse;

    protected EmployeeServices $employeeServices;

    public function __construct(EmployeeServices $employeeServices)
    {
        $this->employeeServices = $employeeServices;
    }

    public function index() {}

    public function store(Request $request)
    {
        $employee = $this->employeeServices->createEmployee($request);
        return $this->createdResponse('Employee created successfully', $employee);
    }

    public function get()
    {
        $employee = $this->employeeServices->getEmployee();

        return $this->successResponse('Employee retrieved successfully', $employee);
    }

    public function detail($id)
    {
        $employee = $this->employeeServices->getEmployeeById($id);
        return $this->successResponse('Employee retrieved successfully', $employee);
    }

    public function delete($id)
    {
        $this->employeeServices->deleteEmployee($id);
        return $this->successResponse('Employee deleted successfully');
    }

    public function update(Request $request, $id)
    {
        $employee = $this->employeeServices->updateEmployee($request, $id);
        return $this->successResponse('Employee updated successfully', $employee);
    }
}
