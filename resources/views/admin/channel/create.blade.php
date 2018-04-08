@extends('admin.layout')

@section('content')
    <div id="main">
        <section id="two">
            <div class="row">
                <div class="8u 12u$(small)">
                    <h2>创建一个新频道</h2>
                    <p>频道可以对博文分类，并可以作为关键字搜索该频道下的博文。<br>已经存在的频道，不能重复添加哦</p>
                    @foreach($channels as $channel)
                        <span style="color: #49bf9d; margin-right: 0.2em;">{{ $channel->channel }}</span>
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
                    <form method="post" action="{{ route('admin.channels.store') }}">
                        @csrf
                        <div class="row uniform 50%">
                            <div class="12u$"><input type="text" name="channel" id="channel" placeholder="频道" /></div>
                        </div>
                        <br>
                        <ul class="actions">
                            <li><input type="submit" value="创建" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection