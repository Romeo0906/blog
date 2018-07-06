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

    /**
     * AuthController constructor.
     * @param AuthyApi $authyApi
     */
    public function __construct(AuthyApi $authyApi)
    {
        $this->authyApi = $authyApi;
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log in page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * Log in action
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->unauthorize($request->input($this->username()));

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (!$this->attemptLogin($request)) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

        if ($this->twoFactorAuthEnabled($request->only($this->username()))) {
            return view('admin.auth.authy', ['user' => $request->input($this->username())]);
        }

        return $this->sendLoginResponse($request);
    }

    /**
     * Log out action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->unauthorize($this->guard()->user()->{$this->username()});

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('auth.index');
    }

    /**
     * Two factor auth validate action
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function twoFactorAuth(Request $request)
    {
        $authy_id = $this->getAuthyId($request->input('user'));

        if ($this->authyApi->verifyToken($authy_id, $request->token)->ok()) {
            $this->authorize($request->input('user'));
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Two factor auth enabled or not
     *
     * @param $username
     * @return bool
     */
    protected function twoFactorAuthEnabled($username)
    {
        if (User::where($this->username(), $username)->value('authy_enabled') == 1) {
            return true;
        }

        return false;
    }

    /**
     * Get user's authy id by user name
     *
     * @param $username
     * @return mixed
     */
    protected function getAuthyId($username)
    {
        return User::where($this->username(), $username)->value('authy_id');
    }

    /**
     * Authorize user to log in (add two factor auth credential)
     *
     * @param $username
     * @return mixed
     */
    protected function authorize($username)
    {
        return User::where($this->username(), $username)->update(['verified' => 1]);
    }

    /**
     * Unauthorize user to log out (remove two factor auth credential)
     *
     * @param $username
     * @return mixed
     */
    protected function unauthorize($username)
    {
        return User::where($this->username(), $username)->update(['verified' => 0]);
    }
}
