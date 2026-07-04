<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}


    public function index(Request $request)
    {
        $limit = (int) $request->input('per_page', 10);
        $users = $this->userService->list($limit);
        return view('admin.user.index', compact('users'));
    }


    public function show(string $id)
    {
        $user = $this->userService->view($id);
        return view('admin.user.show', compact('user'));
    }


    public function create()
    {
        return view('admin.user.create');
    }


    public function store(StoreUserRequest $request)
    {
        $this->userService->register($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }


    public function edit(string $id)
    {
        $user = $this->userService->view($id);
        return view('admin.user.edit', compact('user'));
    }


    public function update(UpdateUserRequest $request, string $id)
    {
        $this->userService->modify($id, $request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }


    public function destroy(string $id)
    {
        $this->userService->remove($id);

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
