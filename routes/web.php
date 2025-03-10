<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::delete('/users/{user_id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/users/{user_id}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::patch('/users/{user_id}', [UserController::class, 'update'])->name('users.update');

