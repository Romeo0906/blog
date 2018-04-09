@extends('admin.layout')

@section('content')
    <div id="main">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">标题</th>
                    <th scope="col">频道</th>
                    <th scope="col">标签</th>
                    <th scope="col">更新时间</th>
                    <th scope="col">创建时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <th width="5%" scope="row"><span class="icon fa-trash-o text-danger"></span></th>
                        <td><a class="no-border" href="{{ route('admin.posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></td>
                        <td width="10%">{{ $post->channel()->value('channel') }}</td>
                        <td width="25%">
                            @foreach($post->tag as $tag)
                                <span class="badge badge-primary" style="font-size: 70%;">{{ $tag->tag}}</span>
                            @endforeach
                        </td>
                        <td width="15%">{{ date('Y-m-d', strtotime($post->updated_at)) }}</td>
                        <td width="15%">{{ date('Y-m-d', strtotime($post->updated_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links('components.pagination') }}
    </div>
@endsection