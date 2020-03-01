<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Favicon settings -->
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <!-- Customized resources -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />
    <!--[if lte IE 8]><script type="application/javascript" src="{{ asset('js/ie/html5shiv.js') }}"></script><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="{{ asset('css/ie8.css') }}" /><![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @section('head')
    @show
</head>
<body id="top">
    <!-- Header -->
    <header id="header">
        @section('header')
        @show
    </header>
    @section('content')
    @show

    <!-- Footer -->
    <footer id="footer">
        <div class="inner">
            <ul class="icons">
                <li><a href="https://www.linkedin.com/in/%E5%AD%90%E5%BB%BA-%E7%8E%8B-44098b126/" class="icon fa-linkedin" target="_blank"><span class="label">LinkedIn</span></a></li>
                <li><a href="https://github.com/Romeo0906" target="_blank" class="icon fa-github"><span class="label">Github</span></a></li>
                <li><a href="https://weibo.com/zijian000" class="icon fa-weibo" target="_blank"><span class="label">Weibo</span></a></li>
                <li><a href="mailto:zijian0906@gmail.com" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
            </ul>
            <ul class="copyright">
                <li>&copy; 2020 Herman</li><li>版面设计: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/skel.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <!--[if lte IE 8]><script src="{{ asset('js/ie/respond.min.js') }}"></script><![endif]-->
    <script src="{{ asset('js/main.js') }}"></script>
    @section('foot')
    @show
</body>
</html>