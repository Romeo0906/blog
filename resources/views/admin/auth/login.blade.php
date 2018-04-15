@extends('home.layout')

@section('content')
    <div id="main">
        <section id="two">
            <div class="row">
                <div class="8u 12u$(small)">
                    <h2>欢迎登录后台系统！</h2>
                    <p>如果您不是博主本人，请移步<a href="{{ route('home.index') }}">博客主页</a>。</p>
                </div>
            </div>
        </section>
        <section id="three">
            <div class="row">
                <div class="8u 12u$(small)">
                    @if(isset($errors) && count($errors) > 0)
                        <ul class="error">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form method="post" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="row uniform 50%">
                            <div class="12u$"><input type="text" name="email" id="email" placeholder="邮箱" /></div>
                            <div class="12u$"><input type="password" name="password" id="password" placeholder="密码" /></div>
                            <div class="12u$"><input type="text" name="token" id="token" placeholder="Authy Token" /></div>
                        </div>
                        <br>
                        <ul class="actions">
                            <li><input type="submit" value="登录" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection