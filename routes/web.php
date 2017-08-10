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

Route::get('node', 'NodeController@index');

Route::get('node/{id?}', 'NodeController@index')->where('id', '[0-9]+');

Route::post('/getFormContent', 'NodeController@getFormContent');

Route::post('/createNodeExecute', 'NodeController@accept');

Route::get('/node/{id?}/detail', 'NodeController@detail')->where('id', '[0-9]+');

Route::get('/node/{id?}/parent', 'NodeController@parent')->where('id', '[0-9]+');

Route::get('/node/{id?}/create/{id1?}', 'NodeController@create')->where(array('id' => '[0-9]+', 'id1' => '[0-9]+'));

Route::delete('node/{id?}', 'NodeController@delete')->where('id', '[0-9]+');
