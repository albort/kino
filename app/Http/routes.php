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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('user/creditcards', 'CreditCardsController', ['only' => ['index', 'store', 'show', 'destroy']]);
Route::resource('movies', 'MoviesController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
Route::resource('series', 'SeriesController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
Route::resource('serie.season', 'SerieSeasonsController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

Route::get('user/cart', 'UserController@showCart');
Route::post('user/addtocart', 'UserController@addtocart');
Route::delete('user/cart', 'UserController@deleteCart');

Route::get('user/orders', 'UserController@showOrders');
Route::get('user/orders/{id}', 'UserController@showOrder');
Route::post('user/checkout', 'UserController@checkOut');