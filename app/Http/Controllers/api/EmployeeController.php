<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
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

    public function store(EmployeeRequest $request)
    {
        $employee = $this->employeeServices->createEmployee($request->validated());
        return $this->createdResponse('Employee created successfully', $employee);
    }

    public function get(EmployeeRequest $request)
    {
        $employee = $this->employeeServices->getEmployee($request);

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

    public function update(EmployeeRequest $request, $id)
    {
        $employee = $this->employeeServices->updateEmployee($request->validated(), $id);
        return $this->successResponse('Employee updated successfully', $employee);
    }
}
