<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index')->name('home');

Route::resource('events', 'EventController');

Route::group(['prefix' => 'parent', 'middleware' => ['auth']], function () {
    Route::get('children', 'ChildrenController@index')->name('parent.children');
    Route::post('registrations', 'ChildrenController@updateRegistrations')->name('parent.registrations');
});
