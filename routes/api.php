<?php

use App\Http\Controllers\Api\V1\Admin\UsersApiController;
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
    Route::apiResource('users', UsersApiController::class);
    Route::get('/users/{searchKeyword}/search', [UsersApiController::class,'getSearched']);
});
