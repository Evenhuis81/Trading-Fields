<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showRegistrationForm () {
        if(session('link')) {
            return view('auth.register');
        }
        if (request()->get('redirect')) {
            define("LINK", url()->previous());
            session()->put('link', constant("LINK"));
            session()->put('guestbid', request()->get('redirect'));
            return view('auth.register');
        }
        return view('auth.register');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
    $isAdman = ($data['role'] == 'isAdman');
    $isGuest = ($data['role'] == 'isGuest');
    // dd($isAdman, $isGuest);
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'isGuest' => $isGuest,
        'isAdman' => $isAdman,
    ]);
    }

    protected function registered()
    {
        if (session('link')) {
            $link = session('link');
            session()->forget('link');
            session()->forget('zip');
            return redirect($link)->with('guestbid', session('guestbid'));
        }
        session()->forget('zip');
        return redirect('/home');
    }

}
