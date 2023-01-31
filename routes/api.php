<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('tasks/description/{id}', [TaskController::class, 'getDescription']);
    Route::get('tasks/filtered', [TaskController::class, 'filterTasks']);
    Route::patch('tasks/toggle-status/{id}', [TaskController::class, 'toggleStatus']);
});
