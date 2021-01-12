<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="utf-8">
    <title>@yield('title',config('app.name'))</title>
    @include('backend.layouts.partials.head')
    @yield('head')
</head>

<body id="page-top">
    <div id="wrapper">

        @include('backend.layouts.partials.sidebar')
        @include('backend.layouts.partials.navbar')
        @yield('content')      
        @include('backend.layouts.partials.footer')

    </div>

    @include('backend.layouts.partials.script')
    @yield('footer')
</body>

</html>