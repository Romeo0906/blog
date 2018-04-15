<?php

namespace App\Http\Controllers\Admin;

use Authy\AuthyApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthyApiController extends Controller
{
    //
    protected $authy;

    public function __construct(AuthyApi $authy)
    {
        $this->authy = $authy;
    }

    public function switch($status)
    {
        if (!method_exists($this, $status)) {
            throw new NotFoundHttpException();
        }

        $this->$status();
    }

    public function on()
    {
        $user = Auth::user();
        $authy_user = $this->authy->registerUser($user->email, $user->phone, '86');

        if ($authy_user->ok()) {
            $user->authy_id = $authy_user->id();
            return $user->save();
        }

        return $authy_user->errors();
    }

    public function off()
    {
        $user = Auth::user();
        $user->authy_id = null;
        $user->verified = 0;
        return $user->save();
    }

    public function verify($token)
    {
        $user = Auth::user();
        $verify = $this->authy->verifyToken($user->authy_id, $token);

        if ($verify->ok()) {
            $user->verified = 1;
            return $user->save();
        }

        return $verify->errors();
    }
}
