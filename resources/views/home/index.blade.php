@extends('home.layout')

@section('content')
    <div id="main">
        @component('components.latest-post', ['post' => $latestPost])
        @endcomponent

        @component('components.card-list', ['posts' => $posts])
        @endcomponent

        <ul class="actions">
            <li><a href="{{ route('home.posts.index') }}" class="button">查看更多</a></li>
        </ul>

        @component('components.contact')
        @endcomponent
    </div>
@endsection