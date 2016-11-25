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
Route::auth();

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::group(['middleware' => 'auth'], function () {

	Route::get('/Chauffeurs', ['as' => 'chauffeurs.index', 'uses' => 'ChauffeurController@index']);
	Route::post('/Chauffeurs/Search/{search}', ['as' => 'chauffeurs.search', 'uses' => 'ChauffeurController@search']);
	Route::get('/Chauffeurs/{id}', ['as' => 'chauffeurs.show', 'uses' => 'ChauffeurController@show']);
	Route::post('/Chauffeurs/Store', ['as' => 'chauffeurs.store', 'uses' => 'ChauffeurController@store']);
	Route::put('/Chauffeurs/{id}', ['as' => 'chauffeurs.update', 'uses' => 'ChauffeurController@update']);
	Route::delete('/Chauffeurs/{id}', ['as' => 'chauffeurs.destroy', 'uses' => 'ChauffeurController@destroy']);


	Route::get('/Overzicht', ['as' => 'pannel.index', 'uses' => 'PannelController@index']);
	Route::post('/Overzicht/Search/{search}', ['as' => 'pannel.search', 'uses' => 'PannelController@search']);

	Route::get('/Planningen', ['as' => 'planningen.index', 'uses' => 'PlanningController@index']);

	Route::get('/Wagens', ['as' => 'vehicles.index', 'uses' => 'VehiclesController@index']);
	Route::post('/Wagens/Search/{search}', ['as' => 'vehicles.search', 'uses' => 'VehiclesController@search']);
	Route::post('/Wagens/Store', ['as' => 'vehicles.store', 'uses' => 'VehiclesController@store']);
	Route::put('/Wagens/{id}', ['as' => 'vehicles.update', 'uses' => 'VehiclesController@update']);
	Route::delete('/Wagens/{id}', ['as' => 'vehicles.destroy', 'uses' => 'VehiclesController@destroy']);
	
	Route::get('/Orders', ['as' => 'orders.index', 'uses' => 'OrderController@index']);
	Route::post('/Orders/Search/{search}', ['as' => 'orders.search', 'uses' => 'OrderController@search']);
	Route::get('/Orders/{id}', ['as' => 'orders.show', 'uses' => 'OrderController@show']);
	Route::post('/Orders/Store', ['as' => 'orders.store', 'uses' => 'OrderController@store']);



	Route::get('/Pakbonnen', ['as' => 'pakbonnen.index', 'uses' => 'PakbonController@index']);
});