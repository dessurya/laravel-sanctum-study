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

// Route::get('feed-user','AuthController@FeedUser');
Route::post('auth/login','AuthController@TokenCreate');

Route::middleware('auth:sanctum')->group( function () {
    Route::prefix('auth/')->group( function () {
        Route::get('logout','AuthController@TokenDestroy');
        Route::get('refresh','AuthController@TokenRefresh');
        Route::get('me','AuthController@userMe');
    });

    Route::prefix('lfb011/')->group( function () {
        Route::get('list','Lsbl\Serv12\Lfb011Controller@list');
        Route::get('open/{Id_global}','Lsbl\Serv12\Lfb011Controller@open');
    });

    Route::prefix('user/')->group( function () {
        Route::get('list/{config?}','UserController@list');
        Route::get('open/{id}','UserController@open');
        Route::post('create','UserController@create');
        Route::put('update/{id}','UserController@update');
        Route::delete('delete/{id}','UserController@delete');
    });

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
