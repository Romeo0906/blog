@extends('home.layout')

@section('content')
    <div id="main">
        @if(count($posts) > 0)
            @include('components.card-list', ['posts' => $posts])
            {{ $posts->links('components.pagination') }}
        @else
            @include('components.empty-list')
        @endif

        @component('components.contact')
        @endcomponent
    </div>
@endsection