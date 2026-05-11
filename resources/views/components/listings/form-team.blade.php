@props(['item' => null])

<div x-bind:class="[completedSteps.includes('teams') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-team" aria-expanded="false" aria-controls="collapse-team">
            <span class="fw-semibold">Team</span>
        </button>
    </h2>
    <div id="collapse-team" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="mb-4 text-center fw-medium">Let visitors meet & connect with your team.</p>
            <div class="row gx-3 gy-3">
                <template x-for="team in teams" x-bind:key="team.id">
                    <div class="col-6 col-md-4">
                        <div class="position-relative px-3 py-3 rounded-3 border shadow-sm bg-white">
                            <div class="mb-2 mx-auto position-relative rounded-circle bg-info"
                                style="width:90px;height:90px;">
                                <picture x-show="team.file_url?.length > 0" class="position-relative">
                                    <img x-bind:src="team.file_url" class="rounded-circle object-fit-cover w-100 h-100" />
                                </picture>
                                <label class="position-absolute top-0 start-0 w-100 h-100 d-inline-flex justify-content-center align-items-center cursor-pointer">
                                    <x-icons.material.add class="text-white" />
                                    <input type="file" x-on:change="handleTeamFile($event, team)" accept="image/*" class="visually-hidden" />
                                </label>
                            </div>
                            <div class="mb-2 position-relative">
                                <input type="text" x-model="team.name" placeholder="Name" autocomplete="off" class="form-control border-2 shadow-none w-100" />
                            </div>
                            <div class="mb-3 position-relative">
                                <input type="text" x-model="team.job" placeholder="Role" autocomplete="off" class="form-control border-2 shadow-none w-100" />
                            </div>
                            <div class="position-relative" x-on:click.away="team.open = false">
                                <div x-show="!!team.listing" class="z-1 position-relative rounded-pill border-gradient">
                                    <div class="d-flex gap-2 mb-1 px-1 py-1 align-items-center rounded-pill text-truncate bg-white">
                                        <picture class="flex-shrink-0">
                                            <img x-bind:src="team.listing?.profile_image_url" width="28px" height="28px" class="rounded-circle" />
                                        </picture>
                                        <div class="flex-grow-1 fw-semibold text-truncate">
                                            <span x-text="team.listing?.name"></span>
                                        </div>
                                        <button x-on:click="removeTeamSuggestion(team)" type="button" class="px-0 py-0 border-0 rounded-pill bg-white text-dark">
                                            <x-icons.material.close />
                                        </button>
                                    </div>
                                </div>
                                <div x-show="!team.listing">
                                    <input type="text" x-model="team.keyword" x-on:input.debounce.500ms="handleTeamKeyword(team)" placeholder="Search & add their lisitng..." class="form-control border-2 shadow-none w-100" />
                                </div>
                                <div class="position-relative">
                                    <div x-show="!!team.open" x-transition
                                        class="position-absolute top-0 start-0 end-0 z-2 my-1 py-1 rounded-3 shadow-sm bg-white">
                                        <template x-for="teamSuggestion in team.suggestions || []" x-bind:key="teamSuggestion.id">
                                            <div x-on:click="handleTeamSuggestion(teamSuggestion, team)" class="position-relative z-3 px-2 py-1 d-flex gap-2 cursor-pointer">
                                                <div class="flex-shrink-0">
                                                    <picture>
                                                        <img x-bind:src="teamSuggestion.profile_image_url" width="24px" height="24px" class="rounded-circle" />
                                                    </picture>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 text-sm fw-semibold" x-text="teamSuggestion.name"></p>
                                                </div>
                                            </div>
                                        </template>
                                        <div x-show="!!team.loading" class="px-3 py-1 fw-medium">
                                            Loading please wait...
                                        </div>
                                        <div x-show="!team.loading && !team.suggestions?.length" class="px-3 py-1 fw-medium">
                                            Nothing found
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div x-on:click="removeTeam(team)" class="z-1 position-absolute top-0 start-100 translate-middle">
                                <button type="button" class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                    <x-icons.material.close />
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="col-6 col-md-4">
                    <div x-on:click="addTeam()" class="h-100 py-5 d-flex align-items-center justify-content-center rounded-3 shadow bg-info text-white">
                        <x-icons.material.add />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
