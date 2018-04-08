<?php

namespace App\Http\Controllers\Home;

use App\Models\Channel;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PostsController extends Controller
{
    //
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->simplePaginate(8);
        return view('home.post.list', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        if (!Cookie::get($post->id)) {
            $post->view++;
            $post->save();
            Cookie::queue($post->id, true, 60);
        }
        return view('home.post.view', ['post' => $post, 'current_channel' => $post->channel]);
    }

    public function loadByChannel(Channel $channel)
    {
        $posts = Post::with(['channel', 'tag'])
                    ->where('channel', $channel->id)
                    ->orderByDesc('created_at')
                    ->simplePaginate(8);
        return view('home.post.list', ['posts' => $posts, 'current_channel' => $channel->id]);
    }

    public function loadByTag(Tag $tag)
    {
        $postIds = $tag->postId()->pluck('post_id');
        $posts = Post::whereIn('id', $postIds)->orderByDesc('id')->simplePaginate(8);
        return view('home.post.list', ['posts' => $posts, 'current_tag' => $tag->id]);
    }
}
