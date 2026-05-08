@props(['item' => null])

<div x-bind:class="[completedSteps.includes('location') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-location" aria-expanded="false" aria-controls="collapse-location">
            <span class="fw-semibold">Location</span>
        </button>
    </h2>
    <div id="collapse-location" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Add your location and tag any training facilities your work from.</p>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Address</span>
                    <p class="small">Let clients know where they can find you. If you’re mobile or online, you can simply enter your city or the area you cover.</p>
                    <input type="text" x-on:input.debounce.500ms="handlePlaceChange()" x-model.fill="placeKeyword"
                        placeholder="Search location..." autocomplete="off" spellcheck="false" class="form-control shadow-sm" />
                    <div x-cloak x-show="placeSuggestions.length > 0">
                        <ul class="my-1 px-0 py-0 rounded-sm border small overflow-y-auto">
                            <template x-for="(placeSuggestion, placeInx) in placeSuggestions" x-bind:key="placeSuggestion.id">
                                <li data-css="map-place-suggestion" class="px-2 py-1 cursor-pointer"
                                    x-bind:data-place-id="placeSuggestion.id"
                                    x-on:click="handlePlaceSuggestionClick(placeSuggestion)"
                                    x-bind:class="{'border-bottom': placeInx < placeSuggestions.length - 1}">
                                    <span x-text="placeSuggestion.name" class="fw-medium"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div x-cloak x-show="placeId?.length > 0 && placeSuggestions?.length == 0" class="mt-3 z-1 shadow-sm rounded-3 border-gradient">
                        <div class="px-3 py-2 rounded-3 bg-white">
                            <span class="fw-semibold" x-text="placeName"></span>
                        </div>
                        <div class="position-absolute top-0 start-100 translate-middle">
                            <button x-on:click.prevent="removePlace()" type="button" class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                <x-icons.material.close />
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Tag a gym, club or studio...</span>
                    <p class="small">If you train clients at a gym, club, or studio listed on GymSelect, tag them here.</p>
                    <input type="text" x-on:input.debounce.500ms="handleMentionChange()" x-model.fill="mentionKeyword"
                        placeholder="Search business name..." autocomplete="off" spellcheck="false" class="form-control shadow-sm" />
                    <div x-cloak x-show="mentionSuggestions.length > 0">
                        <ul class="my-1 px-0 py-0 rounded-sm border small overflow-y-auto">
                            <template x-for="(mentionSuggestion, mentionInx) in mentionSuggestions" x-bind:key="mentionSuggestion.id">
                                <li class="px-2 py-1 cursor-pointer"
                                    x-on:click="handleMentionSuggestionClick(mentionSuggestion)"
                                    x-bind:class="{'border-bottom': mentionInx < mentionSuggestions.length - 1}">
                                    <span x-text="mentionSuggestion.name" class="fw-semibold"></span>
                                    <span x-text="mentionSuggestion.service?.name"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div x-cloak x-show="mentions.length > 0 && mentionSuggestions.length == 0" class="mt-3 position-relative z-1 shadow-sm rounded-3 border border-light">
                        <div class="px-2 py-2 d-flex gap-2 align-items-center rounded-3 bg-white">
                            <div class="flex-shrink-0">
                                <picture>
                                    <img x-bind:src="mentions[0]?.profile_image_url" width="50px" height="50px" class="rounded-circle" />
                                </picture>
                            </div>
                            <div class="flex-grow-1 d-flex flex-column text-truncate">
                                <div class="fw-semibold text-truncate" x-text="mentions[0]?.name"></div>
                                <span class="small" x-text="mentions[0]?.service?.name"></span>
                            </div>
                            <div class="flex-shrink-0">
                                <a x-bind:href="mentions[0]?.permalink" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-gradient fw-semibold rounded-3">
                                    View
                                </a>
                            </div>
                        </div>
                        <div class="position-absolute top-0 start-100 translate-middle">
                            <button x-on:click.prevent="removeMention(mentions[0])" type="button" class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                <x-icons.material.close />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>