<?php

namespace App\Services;

use App\Repositories\Implementation\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $userData) : User
    {
        try {
            $validatedData = $this->validateUserData($userData);
            return $this->userRepository->createUser($validatedData);
        } catch (ValidationException $e) {
            throw new Exception("Validation Error: " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("Failed to create user: " . $e->getMessage());
        }
    }

    public function updateUser(array $userData, int $user_id) : User
    {
        try {
            $validatedData = $this->validateUserData($userData);
            return $this->userRepository->updateUser($validatedData, $user_id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("User not found.");
        } catch (ValidationException $e) {
            throw new Exception("Validation Error: " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("Failed to update user: " . $e->getMessage());
        }
    }

    public function fetchUserById(int $user_id) : User
    {
        try {
            return $this->userRepository->fetchUserById($user_id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("User not found.");
        }
    }

    public function fetchAllUsers() : Collection
    {
        try {
            return $this->userRepository->fetchAllUsers();
        } catch (Exception $e) {
            throw new Exception("Failed to fetch users: " . $e->getMessage());
        }
    }

    public function fetchAllPaginatedUsers(int $perPage = 10) : LengthAwarePaginator
    {
        try {
            return $this->userRepository->fetchAllPaginatedUsers($perPage);
        } catch (Exception $e) {
            throw new Exception("Failed to fetch paginated users: " . $e->getMessage());
        }
    }

    public function deleteUserById(int $user_id) : void
    {
        try {
            $this->userRepository->deleteUserById($user_id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("User not found.");
        } catch (Exception $e) {
            throw new Exception("Failed to delete user: " . $e->getMessage());
        }
    }

    private function validateUserData(array $userData) : array
    {
        $validator = Validator::make($userData, User::validationRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}