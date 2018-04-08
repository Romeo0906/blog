@extends('admin.layout')

@section('content')
    <div id="main">
        <div class="card float-left col-lg-3-5 col-md-12 col-sm-12">
            <div class="card-body">
                <h5 class="card-title">博文</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $counts['post'] }} 篇博文</h6>
                <a href="{{ route('admin.posts.index') }}" class="card-link no-border fa fa-th-list"></a>
                <a href="{{ route('admin.posts.create') }}" class="card-link no-border fa fa-pencil"></a>
            </div>
        </div>
        <div class="float-left blank"></div>
        <div class="card float-left col-lg-3-5 col-md-12 col-sm-12">
            <div class="card-body">
                <h5 class="card-title">频道</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $counts['channel'] }} 个频道</h6>
                <a href="{{ route('admin.channels.index') }}" class="card-link no-border fa fa-th-list"></a>
                <a href="{{ route('admin.channels.create') }}" class="card-link no-border fa fa-pencil"></a>
            </div>
        </div>
        <div class="float-left blank"></div>
        <div class="card float-left col-lg-3-5 col-md-12 col-sm-12">
            <div class="card-body">
                <h5 class="card-title">标签</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $counts['tag'] }} 个标签</h6>
                <a href="{{ route('admin.tags.index') }}" class="card-link no-border fa fa-th-list"></a>
                <a href="{{ route('admin.tags.create') }}" class="card-link no-border fa fa-pencil"></a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
@endsection