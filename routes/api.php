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

//All version 1 routes
Route::prefix('v1')->group(function () {

    //all product v1 routes
    Route::prefix('product')->group(function () {
        Route::post('store', 'Api\v1\ProductController@store');
        Route::get('show/{id}', 'Api\v1\ProductController@show');
        Route::get('index', 'Api\v1\ProductController@index');
        Route::put('update/{id}', 'Api\v1\ProductController@update');
        Route::delete('destroy/{id}', 'Api\v1\ProductController@destroy');
        
        Route::get ('showDeleted', 'Api\v1\ProductController@showDeleted');
    });

    //Sales v1 routes
    Route::prefix('sales')->group(function () {
        Route::post('store', 'Api\v1\SalesController@store');
    });

    //Cart v1 routes
    Route::prefix('cart')->group(function () {
        Route::post('store', 'Api\v1\CartController@store');
        Route::get('index', 'Api\v1\CartController@index');
    });
});
