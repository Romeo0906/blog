<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class ChannelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $channels = Channel::all();
        return view('admin.channel.index', ['channels' => $channels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.channel.create');
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
           'channel' => 'required|unique:channels,channel|max:25'
        ]);

        $channel = new Channel();
        $channel->channel = $request->channel;
        $channel->save();

        return redirect()
                ->route('admin.channels.create')
            ->withErrors('频道 ' . $request->channel . ' 创建成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        //
        return view('admin.channel.edit', ['channel' => $channel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Channel $channel)
    {
        //
        $request->validate([
            'channel' => [
               'required',
               'max:25',
               Rule::unique('channels')->ignore($channel->id)
           ]
        ]);

        $channel->channel = $request->channel;
        $channel->save();

        return redirect()
                ->route('admin.channels.index')
                ->withErrors('频道 ' . $channel->channel . ' 修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        //
        try {
            if ($channel->post()->count() > 0) {
                throw new Exception('该频道下仍有博文，不能删除');
            }
            $channel->delete();
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.channels.index')
                ->withErrors('删除失败！' . $e->getMessage() . "。");
        }

        return redirect()
            ->route('admin.channels.index')
            ->withErrors('删除成功！');
    }
}
