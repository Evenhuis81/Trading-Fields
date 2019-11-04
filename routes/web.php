<?php

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::resource('adverts', 'AdvertsController');
        // ->name('create', 'create.advert')
        // ->name('store', 'store.advert')
        // ->name('index', 'index.advert');
        // ->middleware('can:update,advert');

Auth::routes();
