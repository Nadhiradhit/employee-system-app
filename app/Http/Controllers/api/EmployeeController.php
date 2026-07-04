<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Services\EmployeeService;
use App\Trait\ApiResponse;


class EmployeeController extends Controller
{
    use ApiResponse;

    public function __construct(
        private EmployeeService $employeeServices
    ) {}

    public function create(StoreEmployeeRequest $request)
    {
        $employee = $this->employeeServices->register($request->validated());
        return $this->createdResponse('Employee created successfully', $employee);
    }

    public function get(Request $request)
    {
        $limit = (int) $request->input('per_page', 10);

        $keyword = $request->input('keyword') ?? '';

        $sortBy = $request->input('sort') ?? 'desc';

        $sortColumn = $request->input('sort_by') ?? 'name';

        $filterByStatus = $request->input('status') ?? '';

        $filterByDepartment = $request->input('department') ?? '';

        $employee = $this->employeeServices->list($keyword, $limit, $sortBy, $filterByStatus, $filterByDepartment, $sortColumn);

        return $this->successResponse('Employee retrieved successfully', $employee);
    }

    public function detail($id)
    {
        $employee = $this->employeeServices->view($id);
        return $this->successResponse('Employee retrieved successfully', $employee);
    }

    public function delete($id)
    {
        $this->employeeServices->remove($id);
        return $this->successResponse('Employee deleted successfully');
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = $this->employeeServices->modify($id, $request->validated());
        return $this->successResponse('Employee updated successfully', $employee);
    }
}
