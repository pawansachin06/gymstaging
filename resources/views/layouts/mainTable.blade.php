<!DOCTYPE html>
<html lang="en">
<head>
    @include('partialsMainTable.head')

    <script src="/gymselectme.com/public/js/toastify.min.js?v=1.1"></script>
    <script src="/gymselectme.com/public/js/helpers.js?v=1.1"></script>
    @stack('header_scripts')

    <link rel="stylesheet" href="/gymselectme.com/public/css/toastify.min.css?v=1.1" />
    <link rel="stylesheet" href="/gymselectme.com/public/css/global.css?v=1.1" />
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

@yield('content')

@include('partialsMainTable.footer')
@stack('footer_scripts')
<footer class="footer">
    
    <ul>
        <li><a href="{{ route('home') }}"> Search </a></li>
        <li><a href="https://gymselectme.com/about">About</a></li>
        <li><a href="{{ route('select.business') }}"> List Your Business </a></li>
        <li><a href="https://gymselectme.com/products">Products</a></li>
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
<script>
    @if(request()->routeIs('home'))
    $(window).on('load', function () {
        $("#page-loader").fadeOut(1);
    });
    @endif

    $(document).ready(function () {
        if ($(window).width() > 560 && $(window).width() < 991) {
            $('body').addClass('ipad-custom-bp');
        }
    });
</script>
</body>
</html>



