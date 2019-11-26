<?php

use Illuminate\Http\Request;

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::resource('/adverts', 'AdvertsController');

Auth::routes();

Route::post('/inputbid', 'AjaxController@inputbid')->middleware('auth');
Route::post('/deletebid', 'AjaxController@deletebid')->middleware('auth');

Route::post('autocomplete', 'AutocompleteController@fetch');
Route::post('/search', 'SearchController@search')->name('search');


// Route::post('/cats', function(Request $request) {
//     dd($request->input());
//     return view('cats');
// });
