<!-- SITE TITTLE -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.seometa')

<!-- FAVICON -->
<link href="{{ url('/favicon.ico') }}" rel="shortcut icon">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="{{ asset('/gymselect/styles/style.css?v='.File::lastModified('gymselect/styles/style.css')) }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/gymselect/styles/responsive.css?v='.File::lastModified('gymselect/styles/responsive.css')) }}" rel="stylesheet" type="text/css">
{{--<link rel="stylesheet" href="{{ mix('/css/mainTablestyles.css') }}">--}}
<!--<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="732ae0d1-e324-4ba8-99e0-e3255eefa447" data-blockingmode="auto" type="text/javascript"></script>-->
@stack('head_scripts')
<!-- Latest compiled and minified CSS -->
<link href="{{ asset('/gymselect/styles/custom.css?v='.File::lastModified('gymselect/styles/custom.css')) }}" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

@php
$headerScripts = @\App\Models\Setting::where('name','ORGANIZATION')->first()->value['HEADER_SCRIPTS'];
@endphp
{!! $headerScripts !!}


