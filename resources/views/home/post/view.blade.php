@extends('home.layout')

@section('content')
    <div id="main">
        <!-- One -->
        <section id="one">
            <header class="major">
                <h2>{{ $post->title }}</h2>
                @foreach($post->tag as $tag)
                    <a class="no-border" href="{{ route('home.posts.tag', ['tag' => $tag->id]) }}"><span class="badge badge-primary">{{ $tag->tag }}</span></a>
                @endforeach
                <div>
                    <p class="float-left">发布于 {{ date('Y 年 m 月 d 日', strtotime($post->created_at)) }}</p>
                    <p class="float-right">{{ $post->view }} 人已阅读</p>
                    <div style="clear: both;"></div>
                </div>
            </header>
            <div class="post-content">
                {!! MarkdownEditor::parse($post->content) !!}
            </div>
            <ul class="actions">
                <li><a href="{{ route('home.posts.index') }}" class="button">返回列表</a></li>
            </ul>
        </section>
        @component('components.contact')
        @endcomponent
    </div>
@endsection