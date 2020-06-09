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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'FlowController@index')->name('home');
Route::post('orden', 'FlowController@order')->name('orden');

Route::post('flow/exito', 'FlowController@success')->name('flow.success');
Route::post('flow/error', 'FlowController@error')->name('flow.error');
Route::post('flow/confirmacion', 'FlowController@confirmation')->name('flow.confirmation');
