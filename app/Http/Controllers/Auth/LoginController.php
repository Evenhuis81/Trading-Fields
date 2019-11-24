<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if(session('link')) {
            return view('auth.login');
        }
        if (request()->get('redirect')) {
            define("LINK", url()->previous());
            session()->put('link', constant("LINK"));
            session()->put('guestbid', request()->get('redirect'));
            // $request->request->remove('redirect');
            // session()->put('temp', url()->previous());
            // session()->forget('temp');
            // return view('auth.login')->with('multiredirect', constant("LINK"));
            return view('auth.login');
        }
        // if (request()->get('multiredirect'))
        // if (session('link')) {
        //     $myPath     = session('link');
        //     $loginPath  = url('/login');
        //     $previous   = url()->previous();

        //     if ($previous = $loginPath) {
        //         session(['link' => $myPath]);
        //     } else {
        //         session(['link' => $previous]);
        //     }
        // } else {
        //     session(['link' => url()->previous()]);
        // }
        return view('auth.login');
    }

    protected function authenticated()
        {
            if (session('link')) {
                $link = session('link');
                session()->forget('link');
                return redirect($link)->with('guestbid', session('guestbid'));
            }
            return redirect('/home');
        }
}
