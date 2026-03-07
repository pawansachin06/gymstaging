@extends('layouts.front')

@push('styles')
<link rel="stylesheet" href="/assets/css/location-boost-cities.css?v={{ config('app.version') }}" />
@endpush

@section('content')
<article x-data="page" class="container">
    <section class="my-4 text-center">
        <div class="px-3 py-4 rounded-3 bg-white shadow-md">
            <h1 class="h4 font-weight-bold">Location Boost</h1>
            <p class="mb-0">
                Dominate your local area or expand into new locations.
                Limited featured spots per area.
            </p>
        </div>
    </section>

    <div class="rounded-3 bg-white shadow-md overflow-hidden">
        <div class="row mx-0 flex-md-row-reverse">
            <div class="col-12 col-md-6 px-0">
                <div id="my-map-container" class="w-100"></div>
            </div>
            <div class="col-12 col-md-6 px-0">
                <div class="px-2 py-2">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <input type="text"
                                autocomplete="off" spellcheck="false"
                                x-on:input.debounce.500ms="keywordChange($el)"
                                placeholder="Search a city, street or postcode..."
                                class="form-control"
                            />
                        </div>
                        <div class="px-2" x-cloak x-show="slotsLoading">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div x-cloak x-show="placeSuggestions.length > 0">
                        <ul class="my-1 px-0 py-0 rounded-sm border small overflow-y-auto">
                            <template x-for="(placeSuggestion, placeInx) in placeSuggestions" x-bind:key="placeSuggestion.id">
                                <li data-css="map-place-suggestion" class="px-2 py-1 cursor-pointer"
                                    x-bind:data-place-id="placeSuggestion.id"
                                    x-on:click="handlePlaceSuggestionClick(placeSuggestion)"
                                    x-bind:class="{'border-bottom': placeInx < placeSuggestions.length - 1}">
                                    <span x-text="placeSuggestion.name"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div x-show="placeSuggestions.length == 0">
                        <p data-css="map-input-example" class="my-1">
                            <span>Example: Manchester, SW1, Camden</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <section class="my-5 text-center">
        <h2 class="h4 mb-4 font-weight-bold">Why Boost Your Listing</h2>
        <div class="row justify-content-center">
            @foreach($benefits as $benefit)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="h-100 px-3 py-4 rounded-3 border border-light bg-white shadow-md">
                        <div data-css="benefit-card-icon-box" class="d-inline-block rounded-circle shadow-md mb-3">
                            <img src="{{ $benefit['icon'] }}" width="64" height="64" alt="icon" class="d-inline-block rounded-circle bg-white" />
                        </div>
                        <h3 class="h5 mb-2 font-weight-bold">{{ $benefit['title'] }}</h3>
                        <p class="mb-0">{{ $benefit['content'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="my-5">
        <h2 class="h4 mb-4 font-weight-bold text-center">FAQs</h2>
        <div class="accordion" id="faqAccordion">
            @foreach($faqs as $faqIndex => $faq)
                <div class="mb-3 bg-white rounded-3 overflow-hidden border border-light shadow-md">
                    <div id="faq-heading{{ $faqIndex }}">
                        <button data-css="faq-btn" class="w-100 px-4 py-3 border-0 bg-white h6 mb-0 font-weight-bold text-left {{ empty($faqIndex) ? '' : 'collapsed' }}" type="button"
                            aria-expanded="{{ empty($faqIndex) ? 'true' : 'false' }}"
                            data-toggle="collapse" data-target="#faq-collapse{{ $faqIndex }}" aria-controls="faq-collapse{{ $faqIndex }}">
                            {{ $faq['title'] }}
                        </button>
                    </div>
                    <div id="faq-collapse{{ $faqIndex }}" class="collapse {{ empty($faqIndex) ? 'show' : '' }}" aria-labelledby="faq-heading{{ $faqIndex }}" data-parent="#faqAccordion">
                        <div class="pt-2 pb-3 px-4">
                            {{ $faq['content'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</article>
@endsection

@push('scripts')
<script type="text/javascript">
    var lat = 37.47352527; var lng = -76.55833509;
    var AVAILABLE_SLOTS_URL = '{{ route('location-boost-cities.available-slots') }}';
</script>
<script defer src="/assets/js/location-boost-cities.js?v={{ config('app.version') }}"></script>
@endpush
