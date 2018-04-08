<?php

Route::name('home.')->namespace('Home')->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('posts', 'PostsController@index')->name('posts.index');
    Route::get('posts/{post}', 'PostsController@show')->name('posts.show');
    Route::get('posts/channel/{channel}', 'PostsController@loadByChannel')->name('posts.channel');
    Route::get('posts/tag/{tag}', 'PostsController@loadByTag')->name('posts.tag');
});
