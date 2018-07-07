<?php

namespace App\Http\Controllers\Home;

use App\Models\Channel;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PostsController extends Controller
{
    /**
     * Post list, 6 per page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->simplePaginate(6);
        return view('home.post.list', ['posts' => $posts]);
    }

    /**
     * Show a post
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $post)
    {
        if (!Cookie::get($post->id)) {
            $post->view++;
            $post->save();
            Cookie::queue($post->id, true, 60);
        }
        return view('home.post.view', ['post' => $post, 'current_channel' => $post->channel]);
    }

    /**
     * Show posts under a channel
     *
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadByChannel(Channel $channel)
    {
        $posts = Post::with(['channel', 'tag'])
                    ->where('channel', $channel->id)
                    ->orderByDesc('created_at')
                    ->simplePaginate(6);
        return view('home.post.list', ['posts' => $posts, 'current_channel' => $channel->id]);
    }

    /**
     * Show posts tagged by a tag
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadByTag(Tag $tag)
    {
        $postIds = $tag->postTag()->pluck('post_id');
        $posts = Post::whereIn('id', $postIds)
                    ->orderByDesc('id')
                    ->simplePaginate(6);
        return view('home.post.list', ['posts' => $posts, 'current_tag' => $tag->id]);
    }
}
