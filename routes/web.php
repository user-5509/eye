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

Route::get('getTreeData', 'NodeController@getTreeData');

Route::get('node', 'NodeController@index');

Route::get('node/{id?}', 'NodeController@index')->where('id', '[0-9]+');

Route::get('/content/node/create/available-types-dropdown', 'NodeController@createNodeAvailableTypesDropdown');

Route::get('/content/node/create/modal', 'NodeController@createNodeModal');

Route::post('/node/create/execute', 'NodeController@createNodeExecute');

Route::get('/content/node/delete/modal', 'NodeController@deleteNodeModal');

Route::delete('node/{id?}/delete', 'NodeController@deleteNodeExecute')->where('id', '[0-9]+');

Route::get('/content/node/cross/modal', 'NodeController@nodeCrossModal');

Route::get('/node/{id?}/detail', 'NodeController@detail')->where('id', '[0-9]+');

Route::get('/node/{id?}/parent', 'NodeController@parent')->where('id', '[0-9]+');

