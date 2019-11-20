<?php

use Illuminate\Http\Request;

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::resource('adverts', 'AdvertsController');

Auth::routes();

Route::post('bids', 'AjaxController@store')->name('bids.store')->middleware('auth');
// /{userid}/{advertid}


Route::post('/cats', function(Request $request) {
    dd($request->input());
    return view('cats');
});