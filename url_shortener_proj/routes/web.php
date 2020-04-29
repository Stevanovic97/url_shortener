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
    return view('home');
})->name('home');


Route::post('/urls', 'UrlController@store')->name('url.store');
Route::get('/urls', 'UrlController@index')->name('urls.index');
Route::get('/urls/{urls}', 'UrlController@details')->name('urls.details');
