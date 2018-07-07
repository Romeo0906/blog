<?php

namespace App\Http\Controllers\Home;

use App\Models\Post;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Home page with 5 recent posts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $latestPost = Post::orderByDesc('id')->first();
        $posts = Post::where('id', '<>', $latestPost->id)->orderByDesc('id')->limit(4)->get();
        return view('home.index', ['latestPost' => $latestPost, 'posts' => $posts]);
    }
}
