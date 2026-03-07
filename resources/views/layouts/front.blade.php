<!DOCTYPE html>
<html lang="en">
<head>
    @include('partialsMainTable.head')
    <link rel="stylesheet" href="/css/toastify.min.css?v=1.1" />

    <link rel="stylesheet" href="/assets/css/global.css?v={{ config('app.version') }}">
    <link rel="stylesheet" href="/assets/css/custom.css?v={{ config('app.version') }}">
    <link rel="stylesheet" href="/assets/css/header.css?v={{ config('app.version') }}">
    <link rel="stylesheet" href="/css/global.css?v={{ config('app.version') }}" />
    @stack('styles')

    <script src="/js/toastify.min.js?v=1.1"></script>
    <script src="/js/helpers.js?v=1.1"></script>
    @stack('header_scripts')
</head>
@php
    $agentClass = 'is-desktop';
    if(\App\Http\Helpers\AppHelper::isMobile()) {
        $agentClass = 'is-mobile';
    }
@endphp
<body class="home-screen {{ auth()->check() ? 'loggedin' : '' }} {{ $agentClass }} {{ @$bodyClass }}">
@if(request()->routeIs('home'))
    <div id="page-loader"></div>
@endif
@include('partialsMainTable.topbar')
<main class="site-main">
    @yield('content')
</main>
<footer class="footer">
    <ul>
        <li><a href="{{ route('home') }}"> Search </a></li>
        <li><a href="/about">About</a></li>
        <li><a href="{{ route('select.business') }}"> List Your Business </a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="{{ route('legals') }}"> Legals </a></li>
        <p>Copyright © {{date('Y')}} GymSelect Limited.</p>
    </ul>
</footer>
<div class="modal fade" id="cookieModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-inline">Cookie Policy</h4>
                <button type="button" class="btn btn-default" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <script id="CookieDeclaration" src="https://consent.cookiebot.com/732ae0d1-e324-4ba8-99e0-e3255eefa447/cd.js" type="text/javascript" async></script>
            </div>
        </div>
    </div>
</div>

@include('sweetalert::alert')

<script defer src="/assets/js/lib/jquery.min.js?v=3.4.1"></script>
<script defer src="/assets/js/lib/jquery-ui.min.js?v=1.12.1"></script>
<script defer src="/assets/js/lib/popper.min.js?v=1.16.0"></script>
<script defer src="/assets/js/lib/bootstrap-4.4.1.min.js?v=4.4.1"></script>
<script defer src="/assets/js/lib/jsrender.min.js?v=1.0.6"></script>
<script defer src="/assets/js/lib/select2.min.js?v=4.0.10"></script>
<script defer src="/assets/js/lib/sweetalert.min.js?v=2.1.2"></script>
<script defer src="/assets/js/lib/sweetalert2.min.js?v=11.26.21"></script>
<script defer src="/assets/js/global.js?v={{ config('app.version') }}"></script>
<script defer src="/assets/js/custom.js?v={{ config('app.version') }}"></script>
@stack('scripts')
<script defer src="/assets/js/lib/alpine.min.js?v=3.15.8"></script>
<script defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places,marker&loading=async&callback=initMap&ver=1.0"></script>
<script async src="https://kit.fontawesome.com/9d34eac652.js" crossorigin="anonymous"></script>

</body>
</html>