<?php

use Illuminate\Support\Facades\Route;


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
    return view('generate');
})->name('home');


Route::post('/urls', 'UrlController@store')->name('url.store');
Route::get('/details/{detail}', 'UrlController@details')->name('urls.details');
Route::get('/{urls}', 'UrlController@views')->name('urls.views');




