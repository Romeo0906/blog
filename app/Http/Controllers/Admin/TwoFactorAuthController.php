<?php

namespace App\Http\Controllers\Admin;

use Authy\AuthyApi as AuthClient;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthController extends Controller
{
    //
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
        if ($status == 'on') {
            $this->enable($request);
        }

        if ($status == 'off') {
            $this->disable();
        }

        return redirect()->route('admin.settings');
    }

    /**
     * Enable two factor auth
     *
     * @param Request $request
     * @return bool
     */
    public function enable(Request $request)
    {
        $request->validate(['token' => ['required', 'numeric']]);

        $user = Auth::user();

        if ($user->authy_id != null && $this->validate($user->authy_id, $request->input('token'))) {
            $user->authy_enabled = 1;
            $user->verified = 1;
            return $user->save();
        }

        if ($this->register($user) && $this->validate($user->authy_id, $request->input('token'))) {
            $user->authy_enabled = 1;
            $user->verified = 1;
            return $user->save();
        }

        return false;
    }

    /**
     * Disable two factor auth
     *
     * @return mixed
     */
    public function disable()
    {
        $user = Auth::user();
        $user->authy_enabled = 0;
        $user->verified = 0;
        return $user->save();
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
    public function validate($authy_id, $token)
    {
        return $this->authClient->verifyToken($authy_id, $token)->ok();
    }
}
