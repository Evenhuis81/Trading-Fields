<?php

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::resource('/adverts', 'AdvertsController');

Auth::routes();

Route::post('bids', 'BidsController@store')->name('bids.store')->middleware('auth');
Route::delete('bids/{bid}', 'BidsController@destroy')->name('bids.destroy')->middleware('auth');

Route::post('acceptedcookies', function() {
    return response('')->cookie('accepted', 'true', 526000);
});

Route::post('/autocomplete', 'AutocompleteController@fetch');
Route::post('/search', 'SearchController@search')->name('search');
Route::post('/search2', 'SearchController@search2')->name('search2');
Route::get('/search', function() {abort(404);});
// Route::get('results', 'SearchController@results')->name('results');
