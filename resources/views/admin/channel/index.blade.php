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
                    <th class="text-center w-30" scope="col">频道</th>
                    <th class="text-center w-10" scope="col">文章</th>
                    <th class="text-center w-10" scope="col">浏览</th>
                    <th class="text-center w-20" scope="col">更新/创建时间</th>
                    <th class="text-center w-15" scope="col">修改</th>
                    <th class="text-center w-15" scope="col">删除</th>
                </tr>
            </thead>
            <tbody>
                @foreach($channels as $channel)
                    <tr>
                        <td>{{ $channel->channel }}</td>
                        <td>{{ $channel->post()->count() }}</td>
                        <td>{{ $channel->post()->sum('view') }}</td>
                        <td>{{ date('m-d', strtotime($channel->updated_at)) . ' / ' . date('m-d', strtotime($channel->created_at)) }}</td>
                        <th class="text-center" scope="row">
                            <a class="no-border" href="{{ route('admin.channels.edit', ['channel' => $channel->id]) }}"><span class="icon fa-pencil-square-o text-success pointer"></span></a>
                        </th>
                        <th class="text-center" scope="row">
                            <span onclick="triggerDeleteForm('{{ route('admin.channels.destroy', ['id' => $channel->id]) }}')" class="icon fa-trash-o text-danger pointer"></span>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form id="delete_form" method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="id" id="post_id">
    </form>
@endsection