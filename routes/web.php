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

Route::name('auth.')->namespace('Admin')->prefix('admin')->group(function () {
    Route::get('/login', 'AuthController@index')->name('index');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::get('/tfa', 'AuthController@redirectToIndex')->name('redirectToIndex');
    Route::post('/tfa', 'AuthController@twoFactorAuth')->name('tfa');
    Route::get('/logout', 'AuthController@logout')->name('logout');
});

Route::name('admin.')->middleware('auth:tfa')->namespace('Admin')->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('/settings','AdminController@setting')->name('settings');
    Route::post('/tfa/{status}', 'TwoFactorAuthController@toggle')->name('tfa');
    Route::resource('tags', 'TagsController');
    Route::resource('channels', 'ChannelsController');
    Route::resource('posts', 'PostsController');
});