<?php

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');

Route::resource('adverts', 'AdvertsController')
        ->name('create', 'create.advert')
        ->name('store', 'store.advert')
        ->name('index', 'index.advert')
        ->middleware('adman');

Auth::routes();
