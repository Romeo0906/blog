<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Authy\AuthyApi;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $decayMinutes = 5;

    protected $redirectTo = '/admin';

    protected $authyApi;


    public function __construct(AuthyApi $authyApi)
    {
        $this->authyApi = $authyApi;
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->verify($request) && $this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('auth.index');
    }

    public function verify(Request $request)
    {
        $authy_id = $this->authyId($request);

        if ($authy_id === null ) {
            return true;
        }

        $verify = $this->authyApi->verifyToken($authy_id, $request->token);

        if ($verify->ok()) {
            return true;
        }

        return false;
    }

    protected function validateLogin(Request $request)
    {
        if ($this->authyId($request) === null) {
            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        } else {
            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
                'token' => 'required|numeric',
            ]);
        }
    }

    protected function authyId(Request $request)
    {
        if (User::where($this->username(), $request->only($this->username()))->value('verified')) {
            return User::where($this->username(), $request->only($this->username()))->value('authy_id');
        }

        return null;
    }
}
