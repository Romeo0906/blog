<?php
/**
 * Created by PhpStorm.
 * User: Romeo
 * Date: 2018/7/6
 * Time: 8:23 PM
 */

namespace App\Services\Auth;


use Illuminate\Auth\SessionGuard;

class TwoFactorAuthGuard extends SessionGuard
{
    /**
     * Add two factor auth validation
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        $user = parent::user();

        if (is_object($user) && $user->authy_enabled && !$user->verified) {
            return null;
        }

        return $user;
    }

    /**
     * Get user unauthorized by two factor auth
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function unauthorizedUser()
    {
        return parent::user();
    }
}