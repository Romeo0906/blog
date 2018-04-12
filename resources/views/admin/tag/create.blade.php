@extends('admin.layout')

@section('content')
    <div id="main">
        <section id="two">
            <div class="row">
                <div class="8u 12u$(small)">
                    <h2>创建一个新标签</h2>
                    <p>标签可以用来标记博文，并可以作为关键字搜索被标记的博文。<br>已经存在的标签，不能重复添加哦</p>
                    @foreach($all_tags as $tag)
                        <span class="badge badge-primary mr-1">{{ $tag->tag }}</span>
                    @endforeach
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
                    <form method="post" action="{{ route('admin.tags.store') }}">
                        @csrf
                        <div class="row uniform 50%">
                            <div class="12u$"><input type="text" name="tag" id="tag" placeholder="标签" /></div>
                        </div>
                        <br>
                        <ul class="actions">
                            <li><input type="submit" value="创建" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection