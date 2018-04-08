<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
