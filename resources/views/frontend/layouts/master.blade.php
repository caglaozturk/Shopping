<!DOCTYPE html>
<html lang="{{config('app.locale')}}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title',config('app.name'))</title>
    @include('frontend.layouts.partials.head')
    @yield('head')
</head>

<body>
    <div class="body-wrapper">
        @include('frontend.layouts.partials.header')
        @yield('content')
        @include('frontend.layouts.partials.footer')
    </div>
        @include('frontend.layouts.partials.script')
        @yield('footer')
</body>

</html>
