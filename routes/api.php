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

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', [App\Http\Controllers\AuthController::class,'registration']);
    Route::post('login', [App\Http\Controllers\AuthController::class,'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class,'logout']);
    Route::get('profile', [App\Http\Controllers\AuthController::class,'profile']);

    Route::resource('/location', \App\Http\Controllers\LocationController::class);

    Route::post('/product_store', [App\Http\Controllers\ProductController::class,'store_product']);
    Route::get('/show_product', [App\Http\Controllers\ProductController::class,'fetch_product']);
    Route::get('/show_specific_product', [App\Http\Controllers\ProductController::class,'fetch']);

    Route::post('/item', [App\Http\Controllers\ItemController::class,'upload_item']);
    Route::get('/search_item', [App\Http\Controllers\ItemController::class,'fetch_spe_item']);

    Route::post('/files', [App\Http\Controllers\FileController::class,'file']);
    Route::post('/main_files', [App\Http\Controllers\FileController::class,'upload_contents_of_main_file']);

    Route::post('/category', [App\Http\Controllers\CategoryController::class,'product_category']);

    Route::post('/category/sub_category', [App\Http\Controllers\CategoryController::class,'sub_category']);
    Route::get('/show_subcategory', [App\Http\Controllers\CategoryController::class,'fetch_sub_category']);




});