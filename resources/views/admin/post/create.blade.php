@extends('admin.layout')

@section('content')
    <div id="main">
        <section id="two">
            <div class="row">
                <div class="8u 12u$(small)">
                    <h2>写一篇新博文</h2>
                    <p>通过写一篇新的博文来记录并分享你新的感悟吧，乐于分享者会拥有更多的智慧！</p>
                </div>
            </div>
        </section>
        <section id="three">
            <div class="row">
                <div class="12u 12u$(small)">
                    @if(isset($errors) && count($errors) > 0)
                        <ul class="error">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form method="post" action="{{ route('admin.posts.store') }}">
                        @csrf
                        <div class="row uniform 50%">
                            <div class="12u$">
                                <label for="title"></label><input type="text" name="title" id="title" placeholder="标题" />
                            </div>
                            <div class="12u$">
                                <label for="description"></label>
                                <input type="text" name="description" id="description" placeholder="简介" />
                            </div>
                            <div class="12u$">
                                <label for="channel"></label>
                                <select name="channel" id="channel">
                                    <option value="">选择频道</option>
                                    @foreach($all_channels as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->channel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="12u$">
                                <label for="tag"></label>
                                <select multiple name="tag[]" id="tag" style="height: 100%">
                                    <option>添加标签</option>
                                    @foreach($all_tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="12u$">
                                <label for="content"></label>
                                <div id="md-editor" style="width: 100%; !important;">
                                    <textarea name="content" id="content" placeholder="内容"></textarea>
                                </div>
                                @include('markdown::encode',['editors'=>['md-editor']])
                            </div>
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