<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StudentController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//public route
Route::post('register', [userController::class,'register']);
Route::post('login', [userController::class,'login']);
Route::post('send-reset-password-email', [PasswordResetController::class,'send_reset_password_email']);
Route::post('reset-password/{token}', [PasswordResetController::class, 'reset']);

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::get('/students/search/{city}', [StudentController::class, 'search']);
//protected route
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout', [userController::class,'logout']);
    Route::get('loggeduser', [userController::class,'logged_user']);
    Route::post('changepassword', [userController::class,'change_password']);

      Route::post('/students', [StudentController::class, 'store']);
  Route::put('/students/{id}', [StudentController::class, 'update']);
  Route::delete('/students/{id}', [StudentController::class, 'destroy']);
  
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});