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

    <div class="my-4">
        <div class="d-sm-none mb-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <input type="text" data-js="keyword-input" x-model="keyword"
                        name="keyword" autocomplete="off" spellcheck="false"
                        x-on:input.debounce.500ms="keywordChange($el)"
                        placeholder="Search a city, street or postcode..."
                        class="form-control rounded-3"
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
        </div>
        <div class="d-sm-none rounded-pill bg-white shadow-md mb-3 px-2 py-2">
            <div class="position-relative">
                <span x-cloak x-bind:style="{transform: activeTab == 'map' ? 'translateX(100%)' : 'translateX(0%)'}"
                    style="background:linear-gradient(45deg, #18b9b5, #6f6adf);transition:transform 300ms ease-in-out;"
                class="position-absolute w-50 h-100 left-0 d-flex align-items-center justify-content-center rounded-pill"></span>
                <div class="position-relative d-flex align-items-center text-center">
                    <a href="" x-on:click.prevent="activeTab = 'list'"
                        x-bind:class="[activeTab == 'list' ? 'text-white' : 'text-dark']"
                        class="d-inline-block w-50 py-2 font-weight-semibold">
                        List View
                    </a>
                    <a href="" x-on:click.prevent="activeTab = 'map'"
                        x-bind:class="[activeTab == 'map' ? 'text-white' : 'text-dark']"
                        class="d-inline-block w-50 py-2 font-weight-semibold">
                        Map View
                    </a>
                </div>
            </div>
        </div>
        <div class="rounded-3 bg-white shadow-md overflow-hidden">
            <div class="row mx-0 flex-md-row-reverse position-relative">
                <div data-css="map-col" class="col-12 col-md-7 px-0">
                    <div id="my-map-container" class="w-100"></div>
                </div>
                <div data-css="data-col" x-cloak x-show="activeTab == 'list'"
                    x-transition.opacity.duration.400ms class="col-12 col-md-5 px-0 bg-white d-sm-block top-0 left-0 right-0 bottom-0">
                    <div id="my-data-container" class="d-flex flex-column flex-grow-1">
                        <div class="px-2">
                            <div class="d-none d-sm-block">
                                <div class="d-flex pt-2 mb-2 align-items-center">
                                    <div class="flex-grow-1">
                                        <input type="text" data-js="keyword-input" x-model="keyword"
                                            name="keyword" autocomplete="off" spellcheck="false"
                                            x-on:input.debounce.500ms="keywordChange($el)"
                                            placeholder="Search a city, street or postcode..."
                                            class="form-control rounded-3"
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
                                <div x-show="placeSuggestions.length == 0 && slots.length == 0">
                                    <p data-css="map-input-example" class="mt-2 mb-0">
                                        <span>Example: Manchester, UK</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div data-css="slots-container" class="px-2 py-2 rounded-3 flex-grow-1">
                            <template x-for="(slot, slotInx) in slots" x-bind:key="slot.id">
                                <div class="mb-3 px-2 py-2 rounded-3 border shadow-sm">
                                    <p class="mb-1 font-weight-semibold text-truncate">
                                        <span x-text="slot.postcode"></span>
                                        &mdash;
                                        <span x-text="getName(slot)"></span>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div class="font-weight-semibold">Featured Spots</div>
                                        <div class="font-weight-semibold">
                                            <span x-text="slot.taken + '/'+ slot.available"></span>
                                            taken
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="d-flex align-items-center">
                                            <template x-for="i in 3" x-bind:key="i">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="14" height="14"
                                                    class="d-inline-block mr-1" x-bind:fill="[i <= slot.taken ? '#9c9c9c' : '#18b9b5']">
                                                    <path d="M480-80q-83 0-156-31.5T197-197t-85.5-127T80-480t31.5-156T197-763t127-85.5T480-880t156 31.5T763-763t85.5 127T880-480t-31.5 156T763-197t-127 85.5T480-80"/>
                                                </svg>
                                            </template>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold">
                                                &pound;<span x-text="slot.price"></span>
                                            </span>
                                            / month
                                        </div>
                                    </div>
                                    <div>
                                        <template x-if="isPlaceAdded(slot)">
                                            <button x-on:click="handlePlaceClick($el, slot)" x-bind:disabled="slot.disabled" type="button"
                                                class="btn w-100 py-2 rounded-3 btn-dark font-weight-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 6 9 17l-5-5"/>
                                                </svg>
                                                <span>Added</span>
                                            </button>
                                        </template>
                                        <template x-if="!isPlaceAdded(slot)">
                                            <button x-on:click="handlePlaceClick($el, slot)" x-bind:disabled="slot.disabled" type="button"
                                                class="btn w-100 py-2 rounded-3 btn-info font-weight-semibold">
                                                <span>Secure Featured Spot</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="drafts.length > 0" x-cloak class="my-4">
        <div data-css="drafts-container" class="px-3 py-3 bg-white shadow-md bottom-0 left-0 right-0">
            <h2 class="h4 mb-2 d-none d-sm-block font-weight-bold">Selected Boost Locations</h2>
            <p class="mb-2 d-sm-none font-weight-bold">
                <span x-text="drafts.length"></span>
                <span x-text="drafts.length > 1 ? 'Locations' : 'Location'"></span>
                added
            </p>
            <div data-js="drafts" class="mb-3">
                <template x-for="(draft, draftInx) in drafts" x-bind:key="draft.id">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <div class="text-truncate">
                            <span x-text="draft.postcode"></span>
                            &mdash;
                            <span x-text="getName(draft)"></span>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0">
                            <div>
                                <span class="">
                                    &pound;<span x-text="toPrice(draft.price)"></span>
                                </span> / month
                            </div>
                            <button x-on:click="handleDraftRemove($el, draft)" type="button" class="btn px-1 py-1 text-secondary shadow-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"/>
                                    <path d="m6 6 12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                <div class="d-flex justify-content-between align-items-center border-bottom">
                    <div class="font-weight-semibold py-1 text-truncate">
                        Monthly Total
                    </div>
                    <div class="d-flex align-items-center flex-shrink-0">
                        <span class="font-weight-semibold">
                            &pound;<span x-text="toPrice(getTotal())"></span>
                            / month
                        </span>
                        <span class="d-inline-block mx-1 px-2"></span>
                    </div>
                </div>
            </div>
            <div class="row px-1">
                <div class="col-12 col-md-6 mb-2">
                    <button x-on:click="handleBoostReset()" type="button" class="btn btn-dark w-100 py-2 rounded-3 font-weight-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="M12 5v14"/>
                        </svg>
                        <span class="align-middle">Boost Another Area</span>
                    </button>
                </div>
                <div class="col-12 col-md-6 mb-2">
                    <button x-on:click="handleDraftAdd()" x-bind:disabled="isCheckingOut" type="button" class="btn btn-info w-100 py-2 rounded-3 font-weight-semibold">
                        <span x-show="isCheckingOut" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="align-middle">Continue</span>
                    </button>
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
    var lat = 54.8476977; var lng = -3.175587;
    var MARKER_IMAGE_URL = '{{ url("storage/markers/{$listing->marker_image}") }}';
    var DRAFTS_ADD_URL = '{{ route('location-boost-cities.add-drafts') }}';
    var DRAFTS_REMOVE_URL = '{{ route('location-boost-cities.remove-drafts') }}';
    var AVAILABLE_SLOTS_URL = '{{ route('location-boost-cities.available-slots') }}';
</script>
<script defer src="/assets/js/location-boost-cities.js?v={{ config('app.version') }}"></script>
@endpush
