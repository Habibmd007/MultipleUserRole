<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;


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
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role->id == 1) {

            $this->redirectTo = route('admin.dashboard');

        }else {
            $this->redirectTo = route('author.dashboard');

        }

        $this->middleware('guest');
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
            'name' => 'unique:users|required|string|max:25',
            'country' => 'required|string|max:25',
            'state' => 'required|string|max:25',
            'gender' => 'required|boolean|max:25',
            'date_of_birth' => 'required|date|max:25',
            'email' => 'required|string|email|max:25|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
    //   dd($data);

        $username = str_slug($data['name']); 
        return User::create([
            'name' => $data['name'],
            'country' => $data['country'],
            'state' => $data['state'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
            'username' => $username,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
