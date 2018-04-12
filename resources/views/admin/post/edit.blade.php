@extends('admin.layout')

@section('content')
    <div id="main">
        <section id="two">
            <div class="row">
                <div class="8u 12u$(small)">
                    <h2>修改博文内容</h2>
                    <p>通过博文来记录并分享你新的感悟吧，乐于分享者会拥有更多的智慧！</p>
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
                    <form method="post" action="{{ route('admin.posts.update', ['post' => $post->id]) }}">
                        @csrf
                        @method('put')
                        <div class="row uniform 50%">
                            <div class="12u$">
                                <label for="title"></label><input type="text" name="title" id="title" value="{{ $post->title }}" />
                            </div>
                            <div class="12u$">
                                <label for="description"></label>
                                <input type="text" name="description" id="description" value="{{ $post->description }}" />
                            </div>
                            <div class="12u$">
                                <label for="channel"></label>
                                <select name="channel" id="channel">
                                    <option value="">选择频道</option>
                                    @foreach($all_channels as $channel)
                                        @if($channel->id == $post->channel)
                                            <option selected value="{{ $channel->id }}">{{ $channel->channel }}</option>
                                            @continue
                                        @endif
                                        <option value="{{ $channel->id }}">{{ $channel->channel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="12u$">
                                <label for="tag"></label>
                                <select multiple name="tag[]" id="tag" style="height: 100%">
                                    <option>添加标签</option>
                                    @foreach($all_tags as $tag)
                                        @if($post->postTag()->where('tag_id', $tag->id)->first())
                                            <option selected value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                            @continue
                                        @endif
                                        <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="12u$">
                                <label for="content"></label>
                                <textarea name="content" id="content" placeholder="内容" rows="12">{{ $post->content }}</textarea>
                            </div>
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