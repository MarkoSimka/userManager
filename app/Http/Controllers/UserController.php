<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {   
        $this->userService = $userService;
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        return $this->handleServiceCall(fn() => $this->userService->createUser($request->all()), 'User created successfully!', '/users');
    }

    public function index()
    {
        $users = $this->userService->fetchAllPaginatedUsers();
        return view('users.index', compact('users'));
    }

    public function update(Request $request, int $user_id)
    {
        return $this->handleServiceCall(fn() => $this->userService->updateUser($request->all(), $user_id), 'User updated successfully!', route('users.index'));
    }

    public function edit(int $user_id)
    {
        $user = $this->userService->fetchUserById($user_id);
        return view('users.edit', compact('user'));
    }

    public function destroy(int $user_id)
    {
        return $this->handleServiceCall(fn() => $this->userService->deleteUserById($user_id), 'User deleted successfully!', '/users');
    }

    private function handleServiceCall(callable $serviceCall, string $successMessage, string $redirectRoute)
    {
        try {
            $serviceCall();
            return redirect($redirectRoute)->with('success', $successMessage);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }
}
