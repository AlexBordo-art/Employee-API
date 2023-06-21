<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 
use App\Http\Controllers\TransactionController; 

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

Route::apiResource('employees', EmployeeController::class)->only(['store']);
Route::post('/employees/{employee}/pay', [EmployeeController::class, 'pay']);
Route::apiResource('transactions', TransactionController::class)->only(['store']);
Route::get('transactions/unpaid', [TransactionController::class, 'unpaid']);
