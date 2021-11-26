<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\BookingsController;


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
Route::post('/register', [UsersController::class,'register']);
Route::post('/login', [UsersController::class,'login']);


Route::group(['middleware' => 'auth:api'], function () {
  Route::get('/get_details', [UsersController::class,'getDetails']);
    Route::get('/users', [UsersController::class,'index']);
    Route::post('/add_user', [UsersController::class,'addUser']);
    Route::put('/status_change/{id}', [UsersController::class,'statusChange']);
    Route::get('/move_to_trash/{id}', [UsersController::class,'moveToTrash']);
    Route::get('/get_user/{id}', [UsersController::class,'view']);
    Route::get('/get_device', [UsersController::class,'getDevice']);
    Route::put('/update_user/{id}', [UsersController::class,'update']);
    
    Route::put('/change_pass/{id}', [UsersController::class,'changePass']);
    Route::get('/get_booking', [BookingsController::class,'getBooking']);
    Route::post('/add_booking', [BookingsController::class,'store']);
    Route::delete('/booking_delete/{id}', [BookingsController::class,'delete']);
    Route::get('/view_booking/{id}', [BookingsController::class,'view']);
    Route::put('/update_booking/{id}', [BookingsController::class,'update']);
  });

