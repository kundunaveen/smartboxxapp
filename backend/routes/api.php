<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\BookingsController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\PageTypeController;
use App\Http\Controllers\Api\PageController;
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

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/send_link', [ForgotPasswordController::class, 'forgot']);
Route::post('/reset_password', [ForgotPasswordController::class, 'reset']);
Route::group(['middleware' => 'auth:api'], function () {
  Route::post('/test', [UsersController::class, 'changePasswordPost']);
  Route::get('/users', [UsersController::class, 'index']);
  Route::get('/get_details', [UsersController::class, 'getDetails']);
  Route::get('/users', [UsersController::class, 'index']);
  Route::post('/add_user', [UsersController::class, 'addUser']);
  Route::put('/status_change/{id}', [UsersController::class, 'statusChange']);
  Route::get('/move_to_trash/{id}', [UsersController::class, 'moveToTrash']);
  Route::get('/get_user/{id}', [UsersController::class, 'view']);
  Route::get('/get_user', [UsersController::class, 'view']);
  Route::get('/get_device', [UsersController::class, 'getDevice']);
  Route::put('/update_user/{id}', [UsersController::class, 'update']);
  Route::post('/update_user', [UsersController::class, 'update']);

  Route::put('/change_pass/{id}', [UsersController::class, 'changePass']);
  Route::post('/change_pass', [UsersController::class, 'changePass']);
  Route::get('/get_booking', [BookingsController::class, 'getBooking']);
  Route::post('/add_booking', [BookingsController::class, 'store']);
  Route::delete('/booking_delete/{id}', [BookingsController::class, 'delete']);
  Route::get('/view_booking/{id}', [BookingsController::class, 'view']);
  Route::put('/update_booking/{id}', [BookingsController::class, 'update']);
  Route::get('/device_list', [BookingsController::class, 'deviceList']);
  Route::delete('/device_delete/{id}', [BookingsController::class, 'deleteDevice']);
  Route::post('/add_device', [BookingsController::class, 'addDevice']);
  Route::put('/device_status_change/{id}', [BookingsController::class, 'statusChange']);
  Route::get('/view_device/{id}', [BookingsController::class, 'viewDevice']);
  Route::put('/update_device/{id}', [BookingsController::class, 'updateDevice']);

  Route::resource('/country', CountryController::class);
  Route::resource('/state', StateController::class);
  Route::resource('/city', CityController::class);
  Route::get('/get_state/{id}', [CityController::class, 'getState']);
  Route::resource('/page-type', PageTypeController::class);
  Route::resource('/page', PageController::class);
  // Route::get('/view_booking/{id}', [BookingsController::class, 'view']);
  // Route::put('/update_booking/{id}', [BookingsController::class, 'update']);
  // Route::get('/device_list', [BookingsController::class, 'deviceList']);

});
