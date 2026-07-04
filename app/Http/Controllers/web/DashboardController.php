<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Services\EmployeeService;

class DashboardController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService
    ) {}

    public function admin()
    {
        $employees = $this->employeeService->list(limit: 5, filterByStatus: 'active', sortColumn: 'joining_date', sortBy: 'desc');
        return view('admin.index', compact('employees'));
    }


    public function user()
    {
        $employees = $this->employeeService->list(limit: 5, filterByStatus: 'active', sortColumn: 'joining_date', sortBy: 'desc');
        return view('users.index', compact('employees'));
    }
}
