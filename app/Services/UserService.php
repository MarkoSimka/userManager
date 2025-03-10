<?php

namespace App\Services;

use App\Repositories\Implementation\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $userData) : User
    {
        $validatedData = $this->validateUserData($userData);
        return $this->userRepository->createUser($validatedData);
    }

    public function updateUser(array $userData, int $user_id) : User
    {
        $validatedData = $this->validateUserData($userData);
        return $this->userRepository->updateUser($validatedData, $user_id);
    }

    public function fetchUserById(int $user_id) : User
    {
        return $this->userRepository->fetchUserById($user_id);
    }

    public function fetchAllUsers() : Collection
    {
        return $this->userRepository->fetchAllUsers();
    }

    public function fetchAllPaginatedUsers(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->userRepository->fetchAllPaginatedUsers($perPage);
    }

    public function deleteUserById(int $user_id) : void
    {
        $this->userRepository->deleteUserById($user_id);
    }

    public function validateUserData(array $userData) : array
    {
        $validator = Validator::make($userData, User::validationRules());

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $validator->validated();
    }
}
