<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\Auth\LoginController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 // employees
 Route::resource('employees', UserController::class);
 Route::get('yearly/leave/{id}/{year}',[UserController::class,'yearlyLeave']);
 Route::post('login', [LoginController::class,'login']);
 //leave
 Route::get('leaves',[LeaveController::class,'index']);
 
 Route::post('leave/employee', [LeaveController::class,'store']);
// calculate salary
 Route::get('calculate/salary/{id}/{date}', [UserController::class,'calculateSalary']);
 // salary
 Route::get('salaries',[AdminUserController::class,'index']);
 Route::post('payment/{id}/status',[AdminUserController::class,'updateStatus']);
