<?php

namespace App\Http\Controllers\Home;

use App\Models\Post;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index()
    {
        $latestPost = Post::orderByDesc('id')->first();
        $posts = Post::where('id', '<>', $latestPost->id)->orderByDesc('id')->limit(6)->get();
        return view('home.index')->with(['latestPost' => $latestPost, 'posts' => $posts]);
    }
}
