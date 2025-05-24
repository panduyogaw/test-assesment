<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;


Route::middleware(['auth:sanctum', 'checkUserStatus', 'logRequest'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/users', [UserController::class, 'index'])->middleware('can:view-users');
    Route::post('/users', [UserController::class, 'store'])->middleware('can:create-users');
    Route::apiResource('tasks', TaskController::class);
    Route::get('/tasks/export', [TaskController::class, 'export'])->middleware('can:viewAny,App\Models\Task');
    Route::get('/logs', [ActivityLogController::class, 'index'])->middleware('can:view-logs');
});
