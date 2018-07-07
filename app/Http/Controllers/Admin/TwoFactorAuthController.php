<?php

namespace App\Http\Controllers\Admin;

use Authy\AuthyApi as AuthClient;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthController extends Controller
{
    // Client of Authy
    protected $authClient;

    /**
     * TwoFactorAuthController constructor.
     * @param AuthClient $authClient
     */
    public function __construct(AuthClient $authClient)
    {
        $this->authClient = $authClient;
    }

    /**
     * Toggle two factor auth to enabled or disabled
     *
     * @param Request $request
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Request $request, $status)
    {
        if (($status == 'on' && $this->enable($request)) || ($status == 'off' && $this->disable($request))) {
            return redirect()->route('admin.settings')->withErrors('设置成功！');
        }

        return redirect()->route('admin.settings')->withErrors('Token 输入有误！');
    }

    /**
     * Enable two factor auth
     *
     * @param Request $request
     * @return bool
     */
    public function enable(Request $request)
    {
        $request->validate(['token' => 'required|numeric|digits_between:6,10']);

        $user = Auth::user();

        if ($user->authy_id != null && $this->auth($user->authy_id, $request->input('token'))) {
            $user->authy_enabled = 1;
            $user->verified = 1;
            return $user->save();
        }

        if ($this->register($user) && $this->auth($user->authy_id, $request->input('token'))) {
            $user->authy_enabled = 1;
            $user->verified = 1;
            return $user->save();
        }

        return false;
    }

    /**
     * Disable two factor auth
     *
     * @param Request $request
     * @return mixed
     */
    public function disable(Request $request)
    {
        $request->validate(['token' => 'required|numeric|digits_between:6,10']);

        $user = Auth::user();

        if ($this->auth($user->authy_id, $request->input('token'))) {
            $user->authy_enabled = 0;
            $user->verified = 0;
            return $user->save();
        }
    }

    /**
     * Register a new authy user
     *
     * @param User $user
     * @return bool
     */
    public function register(User $user)
    {
        $authUser = $this->authClient->registerUser($user->email, $user->phone, $user->country_code);

        if (!$authUser->ok()) {
            return false;
        }

        $user->authy_id = $authUser->id();
        return $user->save();
    }

    /**
     * Validate authy token
     *
     * @param $authy_id
     * @param $token
     * @return bool
     */
    public function auth($authy_id, $token)
    {
        return $this->authClient->verifyToken($authy_id, $token)->ok();
    }
}
