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

Auth::routes();

Route::get('/', 'HomeController@index');

// Cotizaciones
Route::get('cotizaciones', 'EstimateController@index');
Route::get('cotizaciones/exportExcel', 'EstimateController@exportExcel');
Route::post('cotizaciones', 'EstimateController@store');
Route::get('cotizaciones/nuevo', 'EstimateController@create');
Route::patch('cotizaciones/{estimate}', 'EstimateController@update');
Route::delete('cotizaciones/{estimate}', 'EstimateController@destroy');
Route::get('cotizaciones/{estimate}/editar', 'EstimateController@edit');
Route::get('cotizaciones/{estimate}/download', 'EstimateController@download');
Route::get('cotizaciones/{estimate}/pdf', 'EstimateController@pdf');
Route::post('cotizaciones/{estimate}/email', 'EstimateController@email');
Route::post('cotizaciones/{estimate}/changeStatus', 'EstimateController@changeStatus');

// Clientes
Route::get('clientes', 'ClientController@index');
Route::post('clientes', 'ClientController@store');
Route::get('clientes/nuevo', 'ClientController@create');
Route::patch('clientes/{client}', 'ClientController@update');
Route::delete('clientes/{client}', 'ClientController@destroy');
Route::get('clientes/{client}/editar', 'ClientController@edit');
Route::get('clientes/getClientById/{id}', 'ClientController@getClientById');
Route::post('clientes/importClients', 'ClientController@importClients');

// Servicios
Route::get('servicios', 'ServiceController@index');
Route::post('servicios', 'ServiceController@store');
Route::get('servicios/nuevo', 'ServiceController@create');
Route::patch('servicios/{service}', 'ServiceController@update');
Route::delete('servicios/{service}', 'ServiceController@destroy');
Route::get('servicios/{service}/editar', 'ServiceController@edit');
Route::get('servicios/getServiceByTitle/{title}', 'ServiceController@getServiceByTitle');

// Usuarios
Route::get('usuarios', 'UserController@index');
Route::post('usuarios', 'UserController@store');
Route::get('usuarios/nuevo', 'UserController@create');
Route::patch('usuarios/{user}', 'UserController@update');
Route::get('usuarios/{user}', 'UserController@show');
Route::delete('usuarios/{user}', 'UserController@destroy');
Route::get('usuarios/{user}/editar', 'UserController@edit');

// Ajustes
Route::get('ajustes', 'SettingController@index');
Route::patch('ajustes/{setting}', 'SettingController@update');

// Reportes
Route::get('reportes', 'ReportController@index');
Route::get('reportes/exportExcel', 'ReportController@exportExcel');

// Emails
Route::get('emails', 'EmailController@index');

// Track Emails
Route::get('tracker/opened/{email}', 'TrackerController@opened');
