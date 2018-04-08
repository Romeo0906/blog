<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    //
    use AuthenticatesUsers;

//    protected $decayMinutes = 5;

    protected $redirectTo = '/admin';

    public function index()
    {
        return view('admin.auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
