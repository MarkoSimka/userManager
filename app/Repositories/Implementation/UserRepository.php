<?php

namespace App\Repositories\Implementation;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface {
    
    public function createUser(array $userData): User
    {
        return User::create($userData);
    }   

    public function updateUser(array $userData, int $user_id): User
    {
        $user = User::findOrFail($user_id);
        $user->update($userData);
        return $user;
    }

    public function fetchUserById(int $user_id): User
    {
        return User::findOrFail($user_id);
    }

    public function fetchAllUsers(): Collection
    {
        return User::all();
    }

    public function fetchAllPaginatedUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    public function deleteUserById(int $user_id): void
    {
        $user = User::findOrFail($user_id);
        $user->delete();
    }
}