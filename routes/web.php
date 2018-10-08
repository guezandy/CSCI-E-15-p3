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

Route::view('/', 'index');

Route::post('/calculate', ['as'=> 'CalculatePace', 'uses'=> 'FormController@calculatePace']);

Route::fallback(function () {
    // TODO(andrew) Add a fun thing here
    return 'No view found';
});
