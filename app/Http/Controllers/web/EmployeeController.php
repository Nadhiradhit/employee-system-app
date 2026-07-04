<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService
    ) {}


    public function index(Request $request)
    {
        $limit = (int) $request->input('per_page', 10);

        $keyword = $request->input('keyword') ?? '';

        $sortBy = $request->input('sort') ?? 'desc';

        $sortColumn = $request->input('sort_by') ?? 'name';

        $filterByStatus = $request->input('status') ?? '';

        $filterByDepartment = $request->input('department') ?? '';

        $employees = $this->employeeService->list($keyword, $limit, $sortBy, $filterByStatus, $filterByDepartment, $sortColumn);

        if (Auth::user()->is_admin) {
            return view('admin.employee.index', compact('employees'));
        }

        return view('users.employee.index', compact('employees'));
    }


    public function show(string $user_id)
    {
        $employee = $this->employeeService->view($user_id);

        if (Auth::user()->is_admin) {
            return view('admin.employee.show', compact('employee'));
        }

        return view('users.employee.show', compact('employee'));
    }


    public function create()
    {
        $users = $this->employeeService->getUnlinkedUsers();
        return view('admin.employee.create', compact('users'));
    }


    public function store(StoreEmployeeRequest $request)
    {
        $this->employeeService->register($request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }


    public function edit(string $user_id)
    {
        $employee = $this->employeeService->view($user_id);
        return view('admin.employee.edit', compact('employee'));
    }


    public function update(UpdateEmployeeRequest $request, string $user_id)
    {
        $this->employeeService->modify($user_id, $request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }


    public function destroy(string $user_id)
    {
        $this->employeeService->remove($user_id);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
