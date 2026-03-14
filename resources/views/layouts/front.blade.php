<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'GymSelect' }} | GymSelect</title>
    <meta name="description" content="GymSelect" />

    <meta name="color-scheme" content="light" />
    <meta name="theme-color" content="#000000" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="apple-mobile-web-app-title" content="GymSelect" />
    <meta name="apple-mobile-web-app-status-bar" content="#000000" />

    <link rel="preload" href="/assets/fonts/montserrat-latin.woff2" as="font" type="font/woff2" crossorigin />

    @foreach ($stylesArr as $styleLink)
        <link rel="stylesheet" href="{{ $styleLink }}" />
    @endforeach

    <link href="/favicon.ico" rel="shortcut icon" />
</head>

<body class="d-flex flex-column min-vh-100" itemtype="https://schema.org/WebPage">
    <x-header />
    <main class="site-main flex-grow-1 flex-shrink-1">
        {{ $slot }}
    </main>
    <x-footer />
    @foreach ($scriptsArr as $script)
        <script defer src="{{ $script }}"></script>
    @endforeach
</body>

</html>