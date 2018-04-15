<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuthyApiController as Authy;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    //
    public function index()
    {
        $counts = array();

        $counts['post'] = Post::count();
        $counts['tag'] = Tag::count();
        $counts['channel'] = Channel::count();
        return view('admin.index', ['counts' => $counts]);
    }

    public function setting()
    {
        return view('admin.setting', ['admin' => Auth::user()]);
    }

    public function authy(Authy $authy, Request $request)
    {
        switch ($request->action) {
            case 'on':
                $res = $authy->on();
                break;

            case 'off':
                $res = $authy->off();
                break;

            case 'verify':
                $res = $authy->verify($request->token);
                break;

            default:
                throw new NotFoundHttpException();
        }

        if ($res === true) {
            return redirect()
                    ->route('admin.settings');
        }

        return redirect()
                ->route('admin.settings')
                ->withErrors($res);
    }

}
