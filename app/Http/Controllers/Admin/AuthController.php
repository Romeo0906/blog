<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Authy\AuthyApi as AuthClient;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    // Lock time when logging in fails exceeds to threshold
    protected $decayMinutes = 5;

    // Where to redirected to after log in
    protected $redirectTo = '/admin';

    // Client of Authy
    protected $authClient;

    /**
     * AuthController constructor.
     * @param AuthClient $authClient
     */
    public function __construct(AuthClient $authClient)
    {
        $this->authClient = $authClient;
        // Redirect if authenticated, logout not included
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->revocation($request->input($this->username()));

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
            return view('admin.auth.tfa');
        }

        return $this->sendLoginResponse($request);
    }

    /**
     * Two factor auth
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function twoFactorAuth(Request $request)
    {
        $validator = Validator::make($request->all(), ['token' => 'required|numeric|digits_between:6,10']);

        if ($validator->fails()) {
            return view('admin.auth.tfa')->withErrors($validator->errors());
        }

        if (!$user = $this->guard()->unauthorizedUser()) {
            return redirect()->route('auth.index');
        }

        if ($this->authClient->verifyToken($user->authy_id, $request->token)->ok()) {
            $this->authorize($user->{$this->username()});
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return view('admin.auth.tfa')->withErrors(['Token 值输入有误！']);
    }

    /**
     * Two factor auth enabled or not
     *
     * @param $username
     * @return bool
     */
    protected function twoFactorAuthEnabled($username)
    {
        return User::where($this->username(), $username)->value('authy_enabled') == 1;
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
    protected function revocation($username)
    {
        return User::where($this->username(), $username)->update(['verified' => 0]);
    }

    /**
     * Log out action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->revocation($this->guard()->user()->{$this->username()});

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('auth.index');
    }

    /**
     * Redirect to index
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToIndex()
    {
        return redirect()->route('auth.index');
    }
}
