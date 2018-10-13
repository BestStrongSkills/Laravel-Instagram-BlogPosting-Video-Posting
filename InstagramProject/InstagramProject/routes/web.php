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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/login/instagram/callback/', 'HomeController@instagramCallback');
Route::get('/showGallery/{token?}','HomeController@showGallery')->name('showGallery');
Route::post('/view/{token?}','HomeController@view')->name('view');
