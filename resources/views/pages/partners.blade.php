<x-front-layout>
    <section class="container py-4">
        <div class="mb-5 px-3 py-4 text-center rounded-3 border border-light bg-white shadow">
            <h1 class="h4 fw-bold">Partners</h1>
            <p class="mb-0 fw-medium">
                Select and visit all our awesome partners!
            </p>
        </div>
        
        <div class="row mb-5 gy-4">
            @foreach($partners as $i => $partner)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="position-relative pb-4 rounded-4 shadow">
                        <div class="py-3 text-center">
                            <a href="{{ $partner->link }}" data-bs-toggle="collapse"
                                class="d-inline-block" data-bs-target="#collapse-partner-{{ $i }}">
                                <img src="{{ $partner->getUrl('logo') }}" width="250" height="62" alt="{{ $partner->name }}" />
                            </a>
                        </div>
                        <div class="collapse" id="collapse-partner-{{ $i }}">
                            <div class="px-3 py-4">
                                <h2 class="h5 text-info mb-1 fw-bold">
                                    {{ $partner->name }}
                                </h2>
                                <p class="mb-3">{!! nl2br($partner->about_us) !!}</p>
                                <div class="text-center">
                                    <a href="{{ $partner->link }}" target="_blank" rel="noopener noreferrer nofollow"
                                        class="btn btn-sm px-4 btn-info fw-semibold text-white">
                                        Visit Site
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute start-0 end-0 bottom-0">
                            <button class="btn btn-dark w-100 py-0 rounded-4 rounded-top-0 collapsed" type="button" aria-expanded="false" data-bs-toggle="collapse"
                                data-bs-target="#collapse-partner-{{ $i }}" aria-controls="collapse-partner-{{ $i }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="collapse-chevron" width="24" height="24" fill="currentColor" viewBox="0 -960 960 960">
                                    <path d="M465-363.5q-7-2.5-13-8.5L268-556q-11-11-11-28t11-28 28-11 28 11l156 156 156-156q11-11 28-11t28 11 11 28-11 28L508-372q-6 6-13 8.5t-15 2.5-15-2.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    </section>
    <style type="text/css">
        .collapse-chevron {
            transition: transform .3s ease;
        }
        button:not(.collapsed) .collapse-chevron {
            transform: rotate(180deg);
        }
    </style>
</x-front-layout>