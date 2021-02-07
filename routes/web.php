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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Master SKPD
Route::get('/skpd', 'HomeController@skpd')->name('skpd');
Route::post('/skpd', 'HomeController@createskpd')->name('createskpd');
Route::post('/skpd/delete/{id}', 'HomeController@deleteskpd')->name('deleteskpd');

//Nama Perangkat
Route::get('/perangkat', 'HomeController@perangkat')->name('perangkat');
Route::post('/perangkat', 'HomeController@createperangkat')->name('createperangkat');
Route::post('/perangkat/delete/{id}', 'HomeController@deleteperangkat')->name('deleteperangkat');


//inventaris
Route::get('/inventaris', 'HomeController@inventaris')->name('inventaris');
Route::post('/inventaris', 'HomeController@createinventaris')->name('createinventaris');
Route::post('/inventaris/delete/{id}', 'HomeController@deleteinventaris')->name('deleteinventaris');


//laporan
Route::get('/laporan', 'HomeController@laporan')->name('laporan');
