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

Route::get('feed-user','AuthController@FeedUser');
// Route::post('sanctum/token/create','AuthController@TokenCreate');
Route::post('auth/login','AuthController@TokenCreate');

Route::get('test', function(){
    return response()->json(['test'=>'test']);
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('user', 'AuthController@allUsers');
    Route::get('auth/logout','AuthController@TokenDestroy');
    Route::get('auth/refresh','AuthController@TokenRefresh');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
