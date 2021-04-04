<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
    'middleware' => ['api']
], function () {
    Route::apiResource('hotels', 'App\Http\Controllers\Api\V1\Admin\HotelsApiController');
    Route::put('/hotels/{id}/book', ['App\Http\Controllers\Api\V1\Admin\HotelsApiController', 'bookHotel']);
    Route::get('/hotels/{searchKeyword}/search', ['App\Http\Controllers\Api\V1\Admin\HotelsApiController','getSearched']);
    Route::apiResource('locations', 'App\Http\Controllers\Api\V1\Admin\LocationsApiController');
    Route::get('/locations/{searchKeyword}/search', ['App\Http\Controllers\Api\V1\Admin\LocationsApiController','getSearched']);
});
