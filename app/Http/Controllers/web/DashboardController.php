<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Admin dashboard — employee management with full CRUD.
     */
    public function admin()
    {
        return view('admin.index');
    }

    /**
     * Regular user dashboard — read-only employee list.
     */
    public function user()
    {
        return view('users.index');
    }
}
