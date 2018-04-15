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
        <form action="{{ route('admin.authy') }}" method="post">
            @csrf
            @if($admin->authy_id === null)
                <input type="hidden" name="action" value="on">
                <div class="form-group">
                    <label for="switch">
                        Two Factor Auth 已经关闭
                    </label>
                    <input type="submit" value="启用">
                </div>
            @elseif($admin->verified === 0)
                <input type="hidden" name="action" value="verify">
                <div class="form-group">
                    <label for="switch">
                        Two Factor Auth 未验证
                    </label>
                    <input class="w-50" type="text" name="token" placeholder="请输入 Authy 的 Token">
                </div>
                <div class="form-group">
                    <input type="submit" value="验证">
                </div>
            @else
                <input type="hidden" name="action" value="off">
                <div class="form-group">
                    <label for="switch">
                        Two Factor Auth 已经启用
                    </label>
                    <input type="submit" value="关闭">
                </div>
            @endif
        </form>
    </div>
@endsection