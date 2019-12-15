<?php

// use App\Events\WebsocketDemoEvent;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');
    Route::post('bids', 'BidsController@store')->name('bids.store')->middleware('auth');
    Route::delete('/bids/{bid}', 'BidsController@destroy')->name('bids.destroy')->middleware('auth');
});

// Route::get('chat', function () {
//     broadcast(new WebsocketDemoEvent('some data'));
//     return view('/chat');
// });

Route::get('/chats', 'ChatsController@index');
Route::get('/messages', 'ChatsController@fetchMessages');
Route::post('/messages', 'ChatsController@sendMessage');

Route::get('/', 'HomeController@index')->name('index');
Route::resource('/adverts', 'AdvertsController');
Auth::routes();

Route::post('/acceptedcookies', function() {
    return response('')->cookie('accepted', 'true', 526000);
});

Route::post('/autocomplete', 'AutocompleteController@fetch');
Route::post('/search', 'SearchController@search')->name('search');
// Route::post('/search2', 'SearchController@search2')->name('search2');
Route::get('/search', function() {abort(404);});
// Route::get('results', 'SearchController@results')->name('results');

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function() {
    Route::namespace('Auth')->group(function(){   
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');
        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
    });
});
