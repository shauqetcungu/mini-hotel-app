<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\V1\Admin\LocationsApiController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LocationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::group(["prefix" => "admin", "middleware" => "auth"], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::get("/admin-info", [AdminController::class, 'getAdminInfo']);

    // Users
    Route::resource('users', UsersController::class);

    // Locations
    Route::resource('locations', LocationsController::class);
    Route::get('/locations/{searchKeyword}/search', [LocationsController::class, 'getSearched']);
    Route::get('/all-locations', [LocationsController::class, 'allLocations']);
    Route::get('/location', [LocationsController::class, 'location']);

    // Hotels
    Route::resource('hotels', HotelsController::class);
    Route::get('/hotels/{searchKeyword}/book', [HotelsController::class, 'getSearched']);
    Route::post('/hotels/{id}/book', [HotelsController::class, 'bookHotel']);
    Route::get('/hotel', [HotelsController::class, 'hotel']);
    Route::get('/book', [HotelsController::class, 'hotel']);
});
