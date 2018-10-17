<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'LinkController@index');
Route::post('/make', 'LinkController@make');

// This route makes sure that the url entered is a hash code within our set parameters, to avoid empty page responses and other errors.
Route::get('{code}', 'LinkController@get')->where('code', '[0-9a-zA-Z]{6}');