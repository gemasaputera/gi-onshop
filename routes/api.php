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
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('details', 'UserController@details');
    // product
    Route::get('products','ProductController@index');
    Route::put('products/{id}','ProductController@update');
    Route::post('products','ProductController@store');
    Route::delete('products/{id}','ProductController@destroy');
    // product gallery
    Route::get('product-galleries','ProductGalleryController@index');
    Route::post('product-galleries','ProductGalleryController@store');
    Route::delete('product-galleries/{id}','ProductGalleryController@destroy');
    // transaction
    Route::post('transactions','TransactionController@store');
    Route::put('transactions/{id}','TransactionController@update');
    Route::get('transactions','TransactionController@index');
    Route::delete('transactions/{id}','TransactionController@destroy');
    // category
    Route::post('category','CategoryController@store');
    Route::put('category/{id}','CategoryController@update');
    Route::get('category','CategoryController@index');
    Route::delete('category/{id}','CategoryController@destroy');
    // customer
    Route::post('customers','CustomerController@store');
    Route::put('customers/{id}','CustomerController@update');
    Route::get('customers','CustomerController@index');
    Route::delete('customers/{id}','CustomerController@destroy');
});
