<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('todos/done/{todo}', [TodoController::class,'updateStatus']);
Route::apiResource('todos',TodoController::class);

Route::get('contacts/editContact/{id}', [ContactController::class, 'editContact']);
Route::get('contacts/showContact/{id}', [ContactController::class, 'showContact']);
Route::apiResource('contacts',ContactController::class);

Route::apiResource('employees',EmployeeController::class);
Route::get('employees/editEmployee/{id}', [EmployeeController::class, 'editEmployee']);
Route::get('employees/showEmployee/{id}', [EmployeeController::class, 'showEmployee']);




