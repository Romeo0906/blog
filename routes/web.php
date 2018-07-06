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

Route::get('/admin/login', 'Admin\AuthController@index')->name('auth.index');
Route::post('/admin/login', 'Admin\AuthController@login')->name('auth.login');
Route::get('/admin/logout', 'Admin\AuthController@logout')->name('auth.logout');
Route::post('/admin/tfa', 'Admin\AuthController@twoFactorAuth')->name('auth.tfa');

Route::name('admin.')->middleware('auth:tfa')->namespace('Admin')->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('/settings','AdminController@setting')->name('settings');
    Route::post('/tfa/{status}', 'TwoFactorAuthController@toggle')->name('tfa');
    Route::resource('tags', 'TagsController');
    Route::resource('channels', 'ChannelsController');
    Route::resource('posts', 'PostsController');
});