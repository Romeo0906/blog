@extends('admin.layout')

@section('content')
    <div id="main">
        @if(isset($errors) && count($errors) > 0)
            <ul class="error">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if($admin->authy_enabled)
            <form action="{{ route('admin.tfa', ['status' => 'off']) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="switch">
                        Two Factor Auth 已经启用
                    </label>
                    <input class="w-50" type="text" name="token" placeholder="请输入 Token">
                </div>
                <div class="form-group">
                    <input type="submit" value="关闭">
                </div>
            </form>
        @else
            <form action="{{ route('admin.tfa', ['status' => 'on']) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="switch">
                        Two Factor Auth 已经关闭
                    </label>
                    <input class="w-50" type="text" name="token" placeholder="请输入 Token">
                </div>
                <div class="form-group">
                    <input type="submit" value="启用">
                </div>
            </form>
        @endif
    </div>
@endsection