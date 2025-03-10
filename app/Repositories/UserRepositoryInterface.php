<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function createUser(array $userData) : User;

    public function updateUser(array $userData, int $user_id) : User;

    public function fetchUserById(int $user_id) : User;

    public function fetchAllUsers() : Collection;

    public function fetchAllPaginatedUsers(int $perPage = 10) : LengthAwarePaginator;

    public function deleteUserById(int $user_id) : void;
}
