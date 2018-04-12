<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags = Tag::all();
        return view('admin.tag.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tag' => 'required|unique:tags,tag|max:25',
        ]);

        $tag = new Tag();
        $tag->tag = $request->tag;
        $tag->save();

        return redirect()
                ->route('admin.tags.create')
                ->withErrors('标签 ' . $request->tag . ' 创建成功！');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
        return view('admin.tag.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
        $request->validate([
            'tag' => [
                'required',
                'max:25',
                Rule::unique('tags')->ignore($tag->id)
            ]
        ]);

        $tag->tag = $request->tag;
        $tag->save();

        return redirect()
            ->route('admin.tags.index')
            ->withErrors('标签 ' . $tag->tag . ' 修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
        try {
            $tag->postTag()->delete();
            $tag->delete();
        } catch (\Throwable $e) {
            return redirect()
                    ->route('admin.tags.index')
                    ->withErrors('删除失败！' . $e->getMessage() . "。");
        }

        return redirect()
                ->route('admin.tags.index')
                ->withErrors('删除成功！');
    }
}
