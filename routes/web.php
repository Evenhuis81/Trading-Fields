<?php

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::resource('adverts', 'AdvertsController');

Auth::routes();

Route::get('addbid', 'AjaxController@addbid')->name('addbid');


Route::get('/cats', function() {
    return view('cats');
});