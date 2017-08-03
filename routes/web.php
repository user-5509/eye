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

//Route::get('/node', function () {
//    return view('welcome');
//});
Route::get('', 'NodeController@subnodes');

Route::get('/node', 'NodeController@index');

Route::get('/node/{id?}', 'NodeController@subnodes')->where('id', '[0-9]+');

Route::get('/node/{id?}/detail', 'NodeController@detail')->where('id', '[0-9]+');

Route::get('/node/{id?}/parent', 'NodeController@parent')->where('id', '[0-9]+');