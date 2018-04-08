@extends('admin.layout')

@section('content')
    <div id="main">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">标签</th>
                    <th scope="col">更新时间</th>
                    <th scope="col">创建时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <th scope="row"><span class="icon fa-minus-circle text-danger"></span></th>
                        <td>{{ $tag->tag }}</td>
                        <td>{{ $tag->updated_at }}</td>
                        <td>{{ $tag->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection