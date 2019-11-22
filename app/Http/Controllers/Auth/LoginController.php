<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        dd(request()->get()->first());
        if ( \request()->get( 'redirect' ) ) {
            // session()->put( 'redirect.url', \request()->get( 'redirect_to' ) );
            // session()->put( 'redirect.url', 'a' );
            session()->put('redirect.url', url()->previous());
            session()->put('redirect.bid', request()->get('guestbid'));
            dd(session()->all());
        }
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (session()->has('guestbd')) {
            if (session('link')) {
                $myPath     = session('link');
                $loginPath  = url('/login');
                $previous   = url()->previous();

                if ($previous = $loginPath) {
                    session(['link' => $myPath]);
                }
                else{
                    session(['link' => $previous]);
                }
            }
            else{
                // session(['guestbid'])
                session(['link' => url()->previous()]);
            }
        }
        return view('auth.login');
    }

    protected function authenticated()
        {
            if(session()->has('redirect.url')) {
                return redirect( session()->get( 'redirect.url' ) );
            }
            if (session('link')) {
                return redirect(session('link'))->with('guestbd', session('guestbd'));
            }
            return redirect('/home');
        }
}
