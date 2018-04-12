@extends('admin.layout')

@section('head')
    <script src="{{ asset('js/extra.js') }}"></script>
@endsection

@section('content')
    <div id="main">
        @if(isset($errors))
            <ul class="error">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}<li/>
                @endforeach
            </ul>
        @endif
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th class="text-center w-40" scope="col">标题</th>
                    <th class="text-center w-10" scope="col">频道</th>
                    <th class="text-center w-10" scope="col">浏览</th>
                    <th class="text-center w-20" scope="col">更新/创建时间</th>
                    <th class="text-center w-10" scope="col">修改</th>
                    <th class="text-center w-10" scope="col">删除</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td class="text-left">{{ $post->title }}</td>
                        <td>{{ $post->channel()->value('channel') }}</td>
                        <td>{{ $post->view }}</td>
                        <td>{{ date('m-d', strtotime($post->updated_at)) . ' / ' . date('m-d', strtotime($post->updated_at)) }}</td>
                        <th class="text-center" scope="row">
                            <a class="no-border" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}"><span class="icon fa-pencil-square-o text-success pointer"></span></a>
                        </th>
                        <th class="text-center" scope="row">
                            <span onclick="triggerDeleteForm('{{ route('admin.posts.destroy', ['id' => $post->id]) }}')" class="icon fa-trash-o text-danger pointer"></span>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links('components.pagination') }}
    </div>
    <form id="delete_form" method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="id" id="post_id">
    </form>
@endsection