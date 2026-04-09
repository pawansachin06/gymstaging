<x-front-layout>
    <div x-data="listing">
        <div class="position-relative py-5 bg-black text-white">
            <img src="https://placehold.co/720x360/png" alt="cover image" class="position-absolute top-0 start-0 end-0 bottom-0 w-100 h-100 object-fit-cover" />
            <div class="position-absolute top-0 start-0 end-0 bottom-0 w-100 h-100" style="background:linear-gradient(0deg,#000000,transparent);"></div>
            <div class="position-relative d-flex flex-column align-items-center justify-content-center">
                <img src="{{ $item->image_url }}" alt="profile image" width="150px" height="150px" class="d-inline-block mb-3 border border-2 border-light rounded-circle" />
                <div class="text-center">
                    <p class="mb-0 h5 fw-bold text-white">
                        {{ $item->name }}
                    </p>
                    <p class="mb-2 text-white">
                        {{ $item->category->name }}
                    </p>
                    <div class="small lh-1 text-white text-opacity-75">
                        @if($item->verified == 1)
                            Verified
                        @endif
                        <x-icons.star filled width="16" height="16" class="align-bottom" />
                        {{ $item->review_average }} &bull; {{ $item->review_count }}
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-4">
            <div class="row flex-lg-row-reverse gy-4">
                <div class="col-12 col-lg-4">
                    <div id="listing-map-container" data-id="{{ $mapId }}" class="rounded shadow"></div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="mb-4 px-4 py-4 d-flex flex-wrap gap-3 rounded-3 shadow">
                        @if(!empty($listingLinks->website))
                            <a href="{{ $listingLinks->website }}" title="website" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.globe />
                            </a>
                        @endif
                        @if(!empty($listingLinks->instagram))
                            <a href="{{ $listingLinks->instagram }}" title="instagram" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.instagram />
                            </a>
                        @endif
                        @if(!empty($listingLinks->facebook))
                            <a href="{{ $listingLinks->facebook }}" title="facebook" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.facebook />
                            </a>
                        @endif
                        @if(!empty($listingLinks->tiktok))
                            <a href="{{ $listingLinks->tiktok }}" title="tiktok" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.tiktok />
                            </a>
                        @endif
                        @if(!empty($listingLinks->twitter))
                            <a href="{{ $listingLinks->twitter }}" title="twitter" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.x-twitter />
                            </a>
                        @endif
                        @if(!empty($listingLinks->linkedin))
                            <a href="{{ $listingLinks->linkedin }}" title="linkedin" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.linkedin-in />
                            </a>
                        @endif
                        @if(!empty($listingLinks->youtube))
                            <a href="{{ $listingLinks->youtube }}" title="youtube" class="btn px-2 btn-dark" target="_blank" rel="noopener noreferrer nofollow">
                                <x-icons.youtube />
                            </a>
                        @endif
                    </div>

                    <div class="mb-4" x-data="{ expanded: false, isOverflowing: false, checkOverflow(el) {
                            this.$nextTick(() => {
                                this.isOverflowing = el.scrollHeight > el.clientHeight;
                            });
                        } }" x-init="checkOverflow($refs.text)">
                        <h2 class="h3 fw-bold">About</h2>
                        <p class="mb-2" x-ref="text" x-bind:class="!expanded ? 'text-truncate-3' : ''">
                            {!! nl2br(@$item->about) !!}
                        </p>
                        <button x-cloak x-show="isOverflowing" x-on:click="expanded = !expanded" type="button" 
                            class="px-0 py-0 rounded border-0 bg-transparent fw-semibold text-info">
                            <span x-text="expanded ? 'Read Less' : 'Read More'">Read More</span>
                        </button>
                    </div>
                    
                    <ul class="nav nav-pills mb-3" id="listing-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="listing-overview-tab" aria-controls="listing-overview" data-bs-target="#listing-overview" aria-selected="true" data-bs-toggle="pill" type="button" role="tab">
                                Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="listing-classes-tab" aria-controls="listing-classes" data-bs-target="#listing-classes" aria-selected="false" data-bs-toggle="pill" type="button" role="tab">
                                Classes
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="listing-pricing-tab" aria-controls="listing-pricing" data-bs-target="#listing-pricing" aria-selected="false" data-bs-toggle="pill" type="button" role="tab">
                                Pricing
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="listing-team-tab" aria-controls="listing-team" data-bs-target="#listing-team" aria-selected="false" data-bs-toggle="pill" type="button" role="tab">
                                Team
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="listing-hours-tab" aria-controls="listing-hours" data-bs-target="#listing-hours" aria-selected="false" data-bs-toggle="pill" type="button" role="tab">
                                Opening Hours
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="listing-contact-tab" aria-controls="listing-contact" data-bs-target="#listing-contact" aria-selected="false" data-bs-toggle="pill" type="button" role="tab">
                                Contact
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="listing-tabs-content">
                        <div class="tab-pane fade show active" id="listing-overview" aria-labelledby="listing-overview-tab" role="tabpanel" tabindex="0">
                            ...
                        </div>
                        <div class="tab-pane fade" id="listing-classes" aria-labelledby="listing-classes-tab" role="tabpanel" tabindex="0">
                            ...
                        </div>
                        <div class="tab-pane fade" id="listing-pricing" aria-labelledby="listing-pricing-tab" role="tabpanel" tabindex="0">
                            ...
                        </div>
                        <div class="tab-pane fade" id="listing-team" aria-labelledby="listing-team-tab" role="tabpanel" tabindex="0">
                            ...
                        </div>
                        <div class="tab-pane fade" id="listing-hours" aria-labelledby="listing-hours-tab" role="tabpanel" tabindex="0">
                            ...
                        </div>
                        <div class="tab-pane fade" id="listing-contact" aria-labelledby="listing-contact-tab" role="tabpanel" tabindex="0">
                            ...
                        </div>
                    </div>

                    <hr />
            
                    <div class="mb-4">
                        <h2 class="h3 fw-bold">
                            What people are saying
                        </h2>
                        <template x-for="review in reviews" x-bind:key="review.id">
                            <div class="mb-3 px-3 py-3 rounded-3 shadow-md">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-3 mb-2 align-items-center">
                                        <div>
                                            <div class="rounded-circle border-gradient-primary">
                                                <img x-bind:src="'https://ui-avatars.com/api/?format=png&background=ffffff&name=' + review.user_name"
                                                    width="40px" height="40px" class="rounded-circle bg-white" />
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold lh-1 text-truncate" x-text="review.user_name"></p>
                                            <small class="fw-medium" x-text="review.created_at_label"></small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <template x-for="i in 5" x-bind:key="i">
                                            <span class="d-inline-block">
                                                <x-icons.star x-show="i <= review.rating" filled width="16" height="16" class="align-bottom" />
                                                <x-icons.star x-show="i > review.rating" width="16" height="16" class="align-bottom" />
                                            </span>
                                        </template>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-1">
                                        <span x-text="review.expanded ? review.message : truncate(review.message, 170)"></span>
                                    </p>
                                    <button x-on:click="review.expanded = !review.expanded"
                                        class="btn btn-link px-0 py-0 text-decoration-none text-info fw-medium"
                                        x-show="review.message.length > 170">
                                        <span x-text="review.expanded ? 'Read less' : 'Read more'"></span>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div x-show="reviewsLast > 1">
                            <div class="d-flex flex-wrap gap-1">
                                <template x-if="reviewsPage > 1">
                                    <button type="button" x-on:click="getReviews(reviewsPage - 1)"
                                        class="btn btn-sm btn-outline-info">
                                        Prev
                                    </button>
                                </template>
                                <template x-for="p in reviewsPages" x-bind:key="p">
                                    <button type="button" x-on:click="getReviews(p)" x-bind:disabled="p === reviewsPage"
                                        class="btn btn-sm btn-outline-info"
                                        x-bind:class="{'opacity-50': p === reviewsPage}">
                                        <span x-text="p"></span>
                                    </button>
                                </template>
                                <template x-if="reviewsPage < reviewsLast">
                                    <button type="button" x-on:click="getReviews(reviewsPage + 1)"
                                        class="btn btn-sm btn-outline-info">
                                        Next
                                    </button>
                                </template>
                                <div x-cloak x-show="reviews.length > 1 && reviewsLoading" class="px-1 align-self-center">
                                    <span class="spinner-border spinner-border-sm text-info" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var latitude = {{ $address->latitude }};
        var longitude = {{ $address->longitude }};
        var MARKER_IMAGE_URL = '{{ $markerUrl }}';
    </script>
</x-front-layout>