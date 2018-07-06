<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Overview of posts, tags, and channels
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $counts = array();

        $counts['post'] = Post::count();
        $counts['tag'] = Tag::count();
        $counts['channel'] = Channel::count();

        return view('admin.index', ['counts' => $counts]);
    }

    /**
     * User settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setting()
    {
        return view('admin.setting', ['admin' => Auth::user()]);
    }
}
