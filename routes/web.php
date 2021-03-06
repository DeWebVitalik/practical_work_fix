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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('files', 'FileController', ['only' => [
    'index', 'create', 'show', 'store', 'destroy'
]])->middleware('auth');

Route::resource('links', 'LinkController', ['only' => [
    'index', 'create', 'store', 'destroy'
]])->middleware('auth');

Route::get('view/{alias}', 'ViewController@index')->name('viewFile');