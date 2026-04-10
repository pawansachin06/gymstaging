@props([ 'title' => null, 'subtitle' => null ])
<div {{ $attributes->merge(['class'=> 'px-3 py-4 text-center rounded-3 border border-light bg-white shadow']) }}>
    @if ($title)
        @if(trim(strip_tags($title)) === trim($title))
            <h1 class="h4 fw-bold">{{ $title }}</h1>
        @else
            {{ $title }}
        @endif
    @endif

    @if ($subtitle)
        @if(trim(strip_tags($subtitle)) === trim($subtitle))
            <p class="mb-0 fw-medium">
                {{ $subtitle }}
            </p>
        @else
            {{ $subtitle }}
        @endif
    @endif

    {{ $slot }}
</div>