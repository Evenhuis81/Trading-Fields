<?php

// use App\Events\WebsocketDemoEvent;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@home')->name('home');
    Route::post('bids', 'BidsController@store')->name('bids.store');
    Route::delete('/bids/{bid}', 'BidsController@destroy')->name('bids.destroy');
    Route::get('payment', 'PaymentController@payment');
    Route::post('subscribe', 'PaymentController@subscribe');
    // ->middleware('check-subscription');
    // Route::get('sub', function () {
    //     dd(redirect()->intented()->getTargetUrl());
    //     dd(auth()->user()->subscribed('main'));
    // });
});

Route::get('/chats', 'ChatsController@index');
Route::get('/messages', 'ChatsController@fetchMessages');
Route::post('/messages', 'ChatsController@sendMessage');

Route::get('/', 'HomeController@index')->name('index');
Route::resource('/adverts', 'AdvertsController');
Auth::routes();

Route::post('/acceptedcookies', function () {
    return response('')->cookie('accepted', 'true', 526000);
});

Route::post('/autocomplete', 'AutocompleteController@fetch');
Route::post('/search', 'SearchController@search')->name('search');
Route::get('/search', function () {
    abort(404);
});

// Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function() {
//     Route::namespace('Auth')->group(function(){
//         //Login Routes
//         Route::get('/login','LoginController@showLoginForm')->name('login');
//         Route::post('/login','LoginController@login');
//         Route::post('/logout','LoginController@logout')->name('logout');
//         //Forgot Password Routes
//         Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
//         Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//         //Reset Password Routes
//         Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
//         Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
//     });
// });

// Route::get('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
// Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
// Route::post('paypal/notify', 'PaypalController@notify');

Route::get('paywithpaypal', function () {
    return view('/paywithpaypal');
});
