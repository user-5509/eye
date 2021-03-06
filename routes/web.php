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

if (Request::is("*")) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, If-Modified-Since, Cache-Control, Pragma");
}

Route::get('', function () {
    return view('main');
});

Route::get('', function () {
    return view('new_main');
});

Route::get('getTreeData', 'NodeController@getTreeData');

Route::get('node/{id?}', 'NodeController@index')->where('id', '[0-9]+');

Route::get('/nodes', 'NodeController@index');

Route::get('/content/node/index', 'NodeController@index');

Route::get('/content/node/create/available-types-dropdown', 'NodeController@createNodeAvailableTypesDropdown');

Route::get('/content/node/create/modal', 'NodeController@createNodeModal');

Route::post('/node/create/execute', 'NodeController@createNodeExecute');

Route::get('/content/node/edit/modal', 'NodeController@editNodeModal');

Route::post('/node/edit/execute', 'NodeController@editNodeExecute');

Route::get('/content/node/delete/modal', 'NodeController@deleteNodeModal');

Route::delete('node/{id?}/delete', 'NodeController@deleteNodeExecute')->where('id', '[0-9]+');

Route::get('/content/node/cross/available-interfaces-dropdown', 'NodeController@crossNodeAvailableInterfacesDropdown');

Route::get('/content/node/cross/available-interfaces-select', 'NodeController@crossNodeAvailableInterfacesSelect');

Route::get('/content/node/cross/modal', 'NodeController@crossModal');

Route::post('/node/cross/execute', 'NodeController@crossExecute');

Route::get('/content/node/massLink/modal', 'NodeController@massLinkModal');

Route::get('/content/node/cross/available-masslink-interfaces-select', 'NodeController@massLinkAvailableInterfacesSelect');

Route::post('/node/massLink/execute', 'NodeController@massLinkExecute');

Route::get('/content/node/decross/modal', 'NodeController@decrossModal');

Route::post('/node/decross/execute', 'NodeController@decrossExecute');

Route::get('/content/node/about', 'NodeController@nodeAbout');

Route::get('/node/{id?}/detail', 'NodeController@detail')->where('id', '[0-9]+');

Route::get('/node/{id?}/parent', 'NodeController@parent')->where('id', '[0-9]+');

Route::post('/node/savePath', 'NodeController@savePath');


Route::get('/content/line/index', 'LineController@index');

Route::get('/content/line/list', 'LineController@getList');

Route::get('/content/line/about', 'LineController@about');

Route::get('/content/line/create/modal', 'LineController@createLineModal');

Route::post('/line/create/execute', 'LineController@createLineExecute');

Route::post('/line/edit/execute', 'LineController@editExecute');

Route::get('/content/line/delete/modal', 'LineController@deleteLineModal');

Route::delete('line/{id?}/delete', 'LineController@deleteLineExecute')->where('id', '[0-9]+');

Route::get('/node/contextSubMenuCreate', 'NodeController@contextSubMenuCreate');

Route::get('/node/contextSubMenuCross', 'NodeController@contextSubMenuCross');

Route::get('/node/contextSubMenuDecross', 'NodeController@contextSubMenuDecross');

Route::get('/node/contextSubMenuMassLink', 'NodeController@contextSubMenuMassLink');

Route::get('/content/node/massUnlink/modal', 'NodeController@massUnlinkModal');

Route::post('/node/massUnlinkExecute', 'NodeController@massUnlinkExecute');

Route::get('/content/node/select', 'NodeController@select');

Route::get('/content/type/index', 'NodeTypeController@index');

Route::get('/content/type/list', 'NodeTypeController@getList');

Route::get('/node/getPath', 'NodeController@getPath');

Route::get('/node/getNodeInterfaces', 'NodeController@getNodeInterfaces');
