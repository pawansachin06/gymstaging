@extends('layouts.front2')

@push('styles')
<link rel="stylesheet" href="/assets/css/location-boost-cities.css?v={{ config('app.version') }}" />
@endpush

@section('content')
<article x-data="page" class="container">
    <section class="my-4 text-center">
        <div class="px-3 py-4 rounded-3 bg-white shadow-md">
            <h1 class="h4 font-weight-bold">
                @if(!empty($locations))
                    Your Boosted Locations
                @else
                    Location Boost
                @endif
            </h1>
            <p class="mb-0">
                @if(!empty($locations))
                    Manage your featured placements.
                @else
                    Dominate your local area or expand into new locations.
                    Limited featured spots per area.
                @endif
            </p>
        </div>
    </section>

    <div class="my-4">
        <div class="d-sm-none mb-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <input type="text" data-js="keyword-input-mobile" x-model="keyword"
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
                    <div id="my-map-container" data-id="{{ $mapId }}" class="w-100"></div>
                </div>
                <div data-css="data-col" x-cloak x-show="activeTab == 'list'"
                    x-transition.opacity.duration.400ms class="col-12 col-md-5 px-0 bg-white d-sm-block top-0 left-0 right-0 bottom-0">
                    <div id="my-data-container" class="h-100 d-flex flex-column flex-grow-1">
                        <div class="px-2">
                            <div class="d-none d-sm-block">
                                <div x-show="!hasActiveSlots">
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
                                    <div x-show="placeSuggestions.length == 0 && (slots.length == 0 || editing)">
                                        <p data-css="map-input-example" class="mt-2 mb-0">
                                            <span>Example: Manchester, UK</span>
                                        </p>
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
                        </div>
                        <div data-css="slots-container" class="px-2 py-2 rounded-3 flex-grow-1">
                            <template x-for="(slot, slotInx) in slots" x-bind:key="slot.id">
                                <div class="mb-3 px-2 py-2 rounded-3 border shadow-sm">
                                    <div class="mb-1 d-flex justify-content-between align-items-center">
                                        <div class="flex-shrink-0">
                                            <p class="mb-0 font-weight-semibold text-truncate">
                                                <span x-text="slot.postcode"></span>
                                                &mdash;
                                                <span x-text="getName(slot)"></span>
                                            </p>
                                        </div>
                                        <div x-show="slot.status == 'active'" class="flex-shrink-0">
                                            <span class="font-weight-bold">
                                                &pound;<span x-text="slot.amount"></span>
                                            </span> / month
                                        </div>
                                    </div>
                                    <div x-show="slot.available <= 2" class="border-bottom pb-1 mb-1 font-weight-semibold">
                                        🔥 High search demand
                                    </div>
                                    <div x-show="slot.status != 'active'">
                                        <div class="d-flex justify-content-between">
                                            <div class="font-weight-semibold">Featured Spots</div>
                                            <div class="font-weight-semibold">
                                                <span x-text="(slot.total - slot.available) + '/'+ slot.total"></span>
                                                taken
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center">
                                                <template x-for="i in 3" x-bind:key="i">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="14" height="14"
                                                        class="d-inline-block mr-1" x-bind:fill="[i <= slot.available ? '#18b9b5' : '#9c9c9c']">
                                                        <path d="M480-80q-83 0-156-31.5T197-197t-85.5-127T80-480t31.5-156T197-763t127-85.5T480-880t156 31.5T763-763t85.5 127T880-480t-31.5 156T763-197t-127 85.5T480-80"/>
                                                    </svg>
                                                </template>
                                            </div>
                                            <div>
                                                <span class="font-weight-bold">
                                                    &pound;<span x-text="slot.amount"></span>
                                                </span>
                                                / month
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="slot.status == 'active'">
                                        <div class="py-1 mb-2 border-top border-bottom">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="14" height="14"
                                                class="d-inline-block mr-1" fill="#4cd20f">
                                                <path d="M480-80q-83 0-156-31.5T197-197t-85.5-127T80-480t31.5-156T197-763t127-85.5T480-880t156 31.5T763-763t85.5 127T880-480t-31.5 156T763-197t-127 85.5T480-80"/>
                                            </svg>
                                            <span class="small font-weight-semibold text-secondary">Active</span>
                                        </div>
                                    </div>
                                    <div x-show="slot.status == 'active'">
                                        <div class="d-flex align-items-center mb-1">
                                            <a x-bind:href="getSearchQuery(slot)" target="_blank" rel="noopener noreferrer nofollow"
                                                class="btn w-100 py-2 rounded-3 btn-dark font-weight-semibold">
                                                <span>View in Search</span>
                                            </a>
                                            <div class="mx-1"></div>
                                            <button type="button" x-on:click="goToCenter(slot)" class="btn btn-outline-dark py-2 rounded-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                            </button>
                                        </div>
                                        <div class="text-center">
                                            <a x-on:click.prevent="handleCancelSlotClick(slot)"
                                                href="#cancelBoostModal" class="text-danger small font-weight-semibold">
                                                Cancel Boost
                                            </a>
                                        </div>
                                    </div>
                                    <div x-show="slot.status != 'active'">
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
                        <div x-cloak x-show="hasActiveSlots" class="px-2 py-2">
                            <button x-on:click="handleBoostReset()" type="button" class="btn btn-outline-info w-100 py-2 rounded-3 font-weight-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"/><path d="M12 5v14"/>
                                </svg>
                                <span class="align-middle">Boost Another Area</span>
                            </button>
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
                                    &pound;<span x-text="toPrice(draft.amount)"></span>
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
            <div class="row px-1 flex-md-row-reverse">
                <div class="col-12 col-md-6 mb-2">
                    <button x-on:click="handleDraftAdd()" x-bind:disabled="isCheckingOut" type="button" class="btn btn-info w-100 py-2 rounded-3 font-weight-semibold">
                        <span x-show="isCheckingOut" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="align-middle">
                            Continue to Checkout
                        </span>
                    </button>
                </div>
                <div class="col-12 col-md-6 mb-2">
                    <button x-on:click="handleBoostReset()" type="button" class="btn btn-dark w-100 py-2 rounded-3 font-weight-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="M12 5v14"/>
                        </svg>
                        <span class="align-middle">Boost Another Area</span>
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
        <h2 class="h4 mb-4 font-weight-bold text-center">
            How Featured Listings Appear in Search
        </h2>
        <div class="mb-4 d-flex align-items-center">
            <div class="lead font-weight-bold">FEATURED</div>
            <div class="mx-2"></div>
            <div class="flex-grow-1" style="background:linear-gradient(90deg, #d1f1f0, #fed2fe);height:14px;"></div>
        </div>
        <div class="row justify-content-center">
            @if($boostedListings?->isNotEmpty())
                @foreach($boostedListings as $boostedListing)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mn-blk">
                        <span class="aoc">Ad | Online Coach</span>
                        @if ($boostedListing->verified)
                            <span class="ver">Verified </span>
                        @endif
                        <div class="list-thumb">
                            <div class="heading d-flex">
                                <div class="list-thumb-heading">
                                    <img src="{{ $boostedListing->getThumbUrl('profile_image') }}" alt="{{ $boostedListing->name }}">
                                    {{ $boostedListing->name }}
                                    <br />
                                    <span>{{ $boostedListing->category->name }}</span>
                                </div>
                                <div class="list-thumb-heading-right w-100">
                                    {!! $boostedListing->reviewStars !!}
                                    <div>
                                        <strong>
                                            {{ $boostedListing->reviewAverage }}
                                            <span>({{ $boostedListing->reviewCount }})</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="list-thumb-img">
                                <a href="{{ route('listing.view', $boostedListing->slug) }}">
                                    <img src="{{ $boostedListing->getCoverImageUrl() }}" alt=" ">
                                </a>
                            </div>
                            <div class="btn-group w-100">
                                <button type="button" class="btn thumb-btn1 features-btn" data-toggle="popover" data-placement="bottom"
                                    title="Viewing Features" data-popover-content="#feature-{{ $boostedListing->id }}">
                                    {{ $boostedListing->featuresLabel }}
                                </button>
                                <a href="{{ route('listing.view', $boostedListing->slug) }}"
                                    target="_blank" rel="noopener noreferrer nofollow"
                                    class="btn thumb-btn1 learn-more">
                                    Learn More
                                </a>
                                <div id="feature-{{ $boostedListing->id }}" class="d-none">
                                    <div class="popover-body">
                                        @foreach ($boostedListing->amentities as $amentity)
                                            <img src="{{ asset('/storage/amenity_icons/' . $amentity['icon']) }}" alt=" ">
                                        @endforeach
                                        <div class="row">
                                            <span class="popover-close close btn btn1" data-target="#feature-{{ $boostedListing->id }}">Close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="my-4">
            <div style="background-color:#cdcdcd;height:14px;"></div>
        </div>
        <div class="row justify-content-center">
            @if($organicListings?->isNotEmpty())
                @foreach($organicListings as $organicListing)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mn-blk">
                        @if ($organicListing->verified)
                            <span class="ver">Verified </span>
                        @endif
                        <div class="list-thumb">
                            <div class="heading d-flex">
                                <div class="list-thumb-heading">
                                    <img src="{{ $organicListing->getThumbUrl('profile_image') }}" alt="{{ $organicListing->name }}">
                                    {{ $organicListing->name }}
                                    <br />
                                    <span>{{ $organicListing->category->name }}</span>
                                </div>
                                <div class="list-thumb-heading-right w-100">
                                    {!! $organicListing->reviewStars !!}
                                    <div>
                                        <strong>
                                            {{ $organicListing->reviewAverage }}
                                            <span>({{ $organicListing->reviewCount }})</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="list-thumb-img">
                                <a href="{{ route('listing.view', $organicListing->slug) }}">
                                    <img src="{{ $organicListing->getCoverImageUrl() }}" alt=" ">
                                </a>
                            </div>
                            <div class="btn-group w-100">
                                <button type="button" class="btn thumb-btn1 features-btn" data-toggle="popover" data-placement="bottom"
                                    title="Viewing Features" data-popover-content="#feature-{{ $organicListing->id }}">
                                    {{ $organicListing->featuresLabel }}
                                </button>
                                <a href="{{ route('listing.view', $organicListing->slug) }}"
                                    target="_blank" rel="noopener noreferrer nofollow"
                                    class="btn thumb-btn1 learn-more">
                                    Learn More
                                </a>
                                <div id="feature-{{ $organicListing->id }}" class="d-none">
                                    <div class="popover-body">
                                        @foreach ($organicListing->amentities as $amentity)
                                            <img src="{{ asset('/storage/amenity_icons/' . $amentity['icon']) }}" alt=" ">
                                        @endforeach
                                        <div class="row">
                                            <span class="popover-close close btn btn1" data-target="#feature-{{ $organicListing->id }}">Close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
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

    <div class="modal fade" id="cancelBoostModal" tabindex="-1" aria-labelledby="cancelBoostModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content rounded-3">
          <div class="modal-header py-2">
            <h5 class="modal-title" id="cancelBoostModalLabel">
                <span x-show="cancelSlot?.loading">Please wait...</span>
                <span x-show="!cancelSlot?.loading">
                    Cancel Boost for <span x-text="cancelSlot?.postcode"></span> &mdash; <span x-text="getName(cancelSlot)"></span>
                </span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div x-show="cancelSlot?.loading" class="py-5 text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div x-show="!cancelSlot?.loading">
                <p class="mb-2">
                    Your subscription will end.
                    Your boost will remain active until <span x-text="cancelSlot?.ends_at" class="text-info font-weight-semibold"></span>
                </p>
                <p class="mb-0" x-text="cancelSlot?.message"></p>
            </div>
          </div>
          <div class="modal-footer px-1 py-1" x-show="!cancelSlot?.loading">
            <div class="row w-100 justify-content-center">
                <div class="col-12 col-md-6 my-1">
                    <button type="button" class="btn btn-dark py-2 w-100 rounded-3" data-dismiss="modal">
                        Keep Boost
                    </button>
                </div>
                <div class="col-12 col-md-6 my-1"
                    x-show="!cancelSlot?.canceled">
                    <button x-on:click="handleCancelSlot()" x-disabled="cancelSlot?.deleting" type="button" class="btn btn-outline-danger py-2 w-100 rounded-3">
                        <span x-show="cancelSlot?.deleting">Please wait...</span>
                        <span x-show="!cancelSlot?.deleting">Cancel Boost</span>
                    </button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
<script defer src="https://unpkg.com/h3-js@4/dist/h3-js.umd.js"></script>
<script defer src="/assets/js/location-boost-cities.js?v={{ config('app.version') }}"></script>
@endpush
