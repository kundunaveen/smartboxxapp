<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

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
Route::get('/get_details', [UsersController::class,'getDetails']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/get_details', [UsersController::class,'getDetails']);
    Route::post('/add_user', [UsersController::class,'addUser']);
    Route::put('/status_change/{id}', [UsersController::class,'statusChange']);
    Route::put('/move_to_trash/{id}', [UsersController::class,'moveToTrash']);
    Route::patch('/get_user/{id}', [UsersController::class,'view']);
    Route::put('/update_user/{id}', [UsersController::class,'update']);
  });


