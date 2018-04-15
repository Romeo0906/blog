@extends('layout')

@section('title', 'Admin Page')

@section('header')
    <div class="inner">
        <a href="{{ route('admin.index') }}" class="image avatar"><img src="{{ asset('images/avatar.jpg') }}" alt="" /></a>
        <h1>
            <strong>王子建</strong><br />
            热爱焦糖瓜子的梦想家<br />
            五迷，健身，有猫
        </h1>
    </div>
    <div class="inner">
        <ul class="channel">
            <li><a class="no-border" href="{{ route('admin.posts.index') }}">博文</a></li>
            <li><a class="no-border" href="{{ route('admin.channels.index') }}">频道</a></li>
            <li><a class="no-border" href="{{ route('admin.tags.index') }}">标签</a></li>
        </ul>
        <ul class="channel">
            <li><a class="no-border" href="{{ route('admin.settings') }}"><span class="fa fa-cog"></span></a></li>
            <li><a class="no-border" href="{{ route('auth.logout') }}"><span class="fa fa-sign-out"></span></a></li>
        </ul>
    </div>
@endsection