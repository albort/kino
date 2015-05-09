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

Route::group(array('prefix' => 'api/v1'), function(){
	Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

	Route::group(array('prefix' => 'admin'), function(){
		Route::post('add/movie', 'MoviesController@store');
		Route::post('add/serie', 'SeriesController@store');
		Route::post('admin/add/serie/{id}/season', 'SerieSeasonsController@store');

		Route::put('update/movie/{id}', 'MoviesController@update');
		Route::put('update/serie/{id}', 'SeriesController@update');
		Route::put('update/serie/{serieID}/season/{seasonID}', 'SerieSeasonsController@update');

		Route::delete('delete/movie/{id}', 'MoviesController@destroy');
		Route::delete('delete/serie/{id}', 'SeriesController@destroy');
		Route::delete('delete/serie/{serieID}/season/{seasonID}', 'SerieSeasonsController@destroy');

		Route::get('orders/', 'AdminController@index');
		Route::get('orders/view/{id}', 'AdminController@show');
		Route::get('orders/user/{id}', 'AdminController@userOrders');
		Route::put('orders/update/{id}', 'AdminController@update');
		Route::delete('orders/delete/{id}', 'AdminController@destroy');
	});

	Route::group(array('prefix' => 'user'), function(){
		Route::resource('creditcards', 'CreditCardsController', ['only' => ['index', 'store', 'show', 'destroy']]);
		Route::get('cart', 'UserController@showCart');
		Route::post('addtocart', 'UserController@addtocart');
		Route::delete('cart', 'UserController@deleteCart');

		Route::get('orders', 'UserController@showOrders');
		Route::get('orders/{id}', 'UserController@showOrder');
		Route::post('checkout', 'UserController@checkOut');
	});

	Route::resource('movies', 'MoviesController', ['only' => ['index', 'show']]);
	Route::resource('series', 'SeriesController', ['only' => ['index', 'show']]);
	Route::resource('serie.season', 'SerieSeasonsController', ['only' => ['index', 'show']]);	
});