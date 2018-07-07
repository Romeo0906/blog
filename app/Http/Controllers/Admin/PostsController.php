<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['channel', 'tag'])->orderByDesc('id')->simplePaginate(10);
        return view('admin.post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:posts,title|max:255',
            'description' => 'required|string',
            'channel' => 'required',
            'tag' => 'required|array',
            'content' => 'required|string'
        ]);


        $post = new Post();
        $post->user = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->channel = $request->channel;
        $post->content = $request->input('content');
        $post->view = 0;
        $post->save();

        foreach ($request->tag as $tag) {
            $post_tag = new PostTag();
            $post_tag->post_id = $post->id;
            $post_tag->tag_id = $tag;
            $post_tag->save();
        }

        return redirect()
                ->route('admin.posts.create')
                ->withErrors('博文创建成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')->ignore($post->id)
            ],
            'description' => ['required', 'string'],
            'channel' => ['required'],
            'tag' => ['required', 'array'],
            'content' => ['required', 'string']
        ]);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->channel = $request->channel;
        $post->content = $request->input('content');
        $post->save();

        $post->postTag()->delete();

        foreach ($request->tag as $tag) {
            $post_tag = new PostTag();
            $post_tag->post_id = $post->id;
            $post_tag->tag_id = $tag;
            $post_tag->save();
        }

        return redirect()
            ->route('admin.posts.index')
            ->withErrors('博文修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $post->postTag()->delete();
            $post->delete();
        } catch (\Throwable $e) {
            return redirect()
                    ->route('admin.posts.index')
                    ->withErrors('删除失败！' . $e->getMessage() . "。");
        }

        return redirect()
                ->route('admin.posts.index')
                ->withErrors('删除成功！');
    }
}
