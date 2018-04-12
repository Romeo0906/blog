@extends('admin.layout')

@section('content')
    <div id="main">
        <section id="two">
            <div class="row">
                <div class="8u 12u$(small)">
                    <h2>修改频道名称</h2>
                    <p>频道可以对博文分类，并可以作为关键字搜索该频道下的博文。<br>已经存在的频道，不能重复添加哦</p>
                    @foreach($all_channels as $c)
                        @if($c->id == $channel->id)
                            @continue
                        @endif
                        <span class="text-active mr-1">{{ $c->channel }}</span>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="three">
            <div class="row">
                <div class="8u 12u$(small)">
                    @if(isset($errors) && count($errors) > 0)
                        <ul class="error">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form method="post" action="{{ route('admin.channels.update', ['channel' => $channel->id]) }}">
                        @method('put')
                        @csrf
                        <div class="row uniform 50%">
                            <div class="12u$"><input type="text" name="channel" id="channel" value="{{ $channel->channel }}" /></div>
                        </div>
                        <br>
                        <ul class="actions">
                            <li><input type="submit" value="修改" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection