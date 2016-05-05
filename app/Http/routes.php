<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});

Route::group(['middleware' => ['web', 'auth', 'localonly']], function () {
    Route::get('/operator/tickets', 'OperatorController@tickets');
    Route::get('/operator/checks', 'OperatorController@checks');
    Route::post('/operator/call', 'OperatorController@call');
    Route::post('/operator/accept', 'OperatorController@accept');
    Route::post('/operator/close', 'OperatorController@close');
    Route::get('/operator/rooms', 'OperatorController@rooms');
    Route::post('/operator/selectroom', 'OperatorController@selectroom');
    Route::get('/operator', 'OperatorController@index');

    Route::post('/reception/createticket', 'ReceptionController@createticket');
    Route::get('/reception/ticketcount', 'ReceptionController@ticketcount');
    Route::get('/reception/timedialog', 'ReceptionController@timedialog');
    Route::get('/reception', 'ReceptionController@index');
});

Route::group(['middleware' => ['web', 'localonly']], function () {
    Route::post('/terminal/select', 'TerminalController@select');
    Route::post('/terminal/createticket', 'TerminalController@createticket');
    Route::get('/terminal/ticketcount', 'TerminalController@ticketcount');
    Route::get('/terminal/ticketcountbyday', 'TerminalController@ticketcountbyday');
    Route::get('/terminal/timedialog', 'TerminalController@timedialog');
    Route::get('/terminal/{terminal}/page', 'TerminalController@page');
    Route::get('/terminal/{terminal}', 'TerminalController@show');
    Route::get('/terminals', 'TerminalController@index');

    Route::post('/panel/select', 'PanelController@select');
    Route::get('/panel/checks', 'PanelController@checks');
    Route::get('/panel/{panel}', 'PanelController@show');
    Route::get('/panels', 'PanelController@index');
});