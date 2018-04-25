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
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        $response = $http->post('http://passport.test/api/auth/login', [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => '2',
                'client_secret' => 'ELKH5zBXdr1YkKSRpdAv8K039648mc0sJ5kvx9bN',
                'username'      => $request->input('email'),
                'password'      => $request->input('password'),
                'scope'         => '*',
            ],
        ]);

        return $response;
    }
}
