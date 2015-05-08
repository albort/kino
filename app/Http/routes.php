<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('admin/add/movie', 'MoviesController@store');
Route::post('admin/add/serie', 'SeriesController@store');
Route::post('admin/add/serie/{id}/season', 'SerieSeasonsController@store');

Route::put('admin/update/movie/{id}', 'MoviesController@update');
Route::put('admin/update/serie/{id}', 'SeriesController@update');
Route::put('admin/update/serie/{serieID}/season/{seasonID}', 'SerieSeasonsController@update');

Route::delete('admin/delete/movie/{id}', 'MoviesController@destroy');
Route::delete('admin/delete/serie/{id}', 'SeriesController@destroy');
Route::delete('admin/delete/serie/{serieID}/season/{seasonID}', 'SerieSeasonsController@destroy');

Route::get('admin/orders/', 'AdminController@index');
Route::get('admin/orders/view/{id}', 'AdminController@show');
Route::get('admin/orders/user/{id}', 'AdminController@userOrders');
Route::put('admin/orders/update/{id}', 'AdminController@update');
Route::delete('admin/orders/delete/{id}', 'AdminController@destroy');

Route::resource('user/creditcards', 'CreditCardsController', ['only' => ['index', 'store', 'show', 'destroy']]);
Route::resource('movies', 'MoviesController', ['only' => ['index', 'show']]);
Route::resource('series', 'SeriesController', ['only' => ['index', 'show']]);
Route::resource('serie.season', 'SerieSeasonsController', ['only' => ['index', 'show']]);

Route::get('user/cart', 'UserController@showCart');
Route::post('user/addtocart', 'UserController@addtocart');
Route::delete('user/cart', 'UserController@deleteCart');

Route::get('user/orders', 'UserController@showOrders');
Route::get('user/orders/{id}', 'UserController@showOrder');
Route::post('user/checkout', 'UserController@checkOut');