<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});



Route::get('/connectfour', 'HomeController@listing');
Route::post('/connectfour', 'HomeController@login');
Route::get('/connectfour/play', 'HomeController@play');
Route::post('/connectfour/makeMove', 'HomeController@makemove');

Route::get ('/resetgame', 'HomeController@resetgame');

Route::resource('/test', 'TestController');
