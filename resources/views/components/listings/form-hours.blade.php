@props(['item' => null])

<div x-bind:class="[completedSteps.includes('hours') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-hours" aria-expanded="false" aria-controls="collapse-hours">
            <span class="fw-semibold">Opening Hours</span>
        </button>
    </h2>
    <div id="collapse-hours" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Manage your opening hours for each day of the week.</p>
            <template x-for="day in timings" x-bind:key="day.key">
                <div class="mb-3">
                    <div class="d-flex gap-3">
                        <div style="min-width:90px;">
                            <p class="mb-0 small fw-semibold" x-text="day.title"></p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" x-model="day.enabled" x-on:change="checkStep('hours')" role="switch" />
                            </div>
                        </div>
                    </div>
                    <div class="px-2 py-2 d-flex flex-column gap-2 rounded-3 shadow-sm">
                        <template x-for="(slot, slotIndex) in day.hours" x-bind:key="slotIndex">
                            <div x-show="slotIndex == 0 || (slotIndex > 0 && day.enabled && !day.is24Hours)">
                                <div class="row gx-2 gy-2 align-items-center">
                                    <div x-show="day.enabled" class="col-12 col-lg-2">
                                        <template x-if="slotIndex == 0">
                                            <div class="d-flex gap-2">
                                                <div class="align-self-start rounded border border-2 border-gradient-primary position-relative z-1 lh-1">
                                                    <input type="checkbox" x-model="day.is24Hours" x-bind:id="'day-' + day.key" class="form-check-input my-0 border-0" />
                                                </div>
                                                <label x-bind:for="'day-' + day.key" class="form-check-label user-select-none small fw-medium">
                                                    24 Hours
                                                </label>
                                            </div>
                                            <label>
                                                <span></span>
                                            </label>
                                        </template>
                                    </div>
                                    <div x-show="day.enabled && !day.is24Hours" class="col-12 col-md-6 col-lg-4.5 ps-4.25">
                                        <div class="position-relative d-flex gap-1 ps-4.5 pe-2 py-2 rounded-3 border user-select-none">
                                            <div class="position-absolute top-50 start-0 translate-middle">
                                                <div class="fw-semibold bg-white">Open:</div>
                                            </div>
                                            <div x-data="{open: false}" x-on:click.away="open = false" class="flex-grow-1 bg-secondary-subtle rounded">
                                                <div x-on:click="open = !open" class="py-1 fw-medium text-center cursor-pointer">
                                                    <span x-text="slot.start.hh || 'HH'"></span>
                                                </div>
                                                <div class="position-relative">
                                                    <div x-show="open" x-transition style="max-height:90px;"
                                                        class="position-absolute start-0 end-0 my-1 py-1 z-2 overflow-y-auto rounded border shadow-sm bg-secondary-subtle">
                                                        <template x-for="i in 23">
                                                            <div x-on:click="slot.start.hh = i.toString().padStart(2, '0'); open = false;"
                                                                class="px-2 fw-medium text-center cursor-pointer">
                                                                <span x-text="i.toString().padStart(2, '0')"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fw-medium">:</div>
                                            <div x-data="{open: false}" x-on:click.away="open = false" class="flex-grow-1 bg-secondary-subtle rounded">
                                                <div x-on:click="open = !open" class="py-1 fw-medium text-center cursor-pointer">
                                                    <span x-text="slot.start.mm || 'MM'"></span>
                                                </div>
                                                <div class="position-relative">
                                                    <div x-show="open" x-transition style="max-height:90px;"
                                                        class="position-absolute start-0 end-0 my-1 py-1 z-2 overflow-y-auto rounded border shadow-sm bg-secondary-subtle">
                                                        <template x-for="i in 59">
                                                            <div x-on:click="slot.start.mm = i.toString().padStart(2, '0'); open = false;"
                                                                class="px-2 fw-medium text-center cursor-pointer">
                                                                <span x-text="i.toString().padStart(2, '0')"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="day.enabled && !day.is24Hours" class="col-12 col-md-6 col-lg-4.5 ps-4.25">
                                        <div class="position-relative d-flex gap-1 ps-4.5 pe-2 py-2 rounded-3 border user-select-none">
                                            <div class="position-absolute top-50 start-0 translate-middle">
                                                <div class="fw-semibold bg-white">Close:</div>
                                            </div>
                                            <div x-data="{open: false}" x-on:click.away="open = false" class="flex-grow-1 bg-secondary-subtle rounded">
                                                <div x-on:click="open = !open" class="py-1 fw-medium text-center cursor-pointer">
                                                    <span x-text="slot.end.hh || 'HH'"></span>
                                                </div>
                                                <div class="position-relative">
                                                    <div x-show="open" x-transition style="max-height:90px;"
                                                        class="position-absolute start-0 end-0 my-1 py-1 z-2 overflow-y-auto rounded border shadow-sm bg-secondary-subtle">
                                                        <template x-for="i in 23">
                                                            <div x-on:click="slot.end.hh = i.toString().padStart(2, '0'); open = false;"
                                                                class="px-2 fw-medium text-center cursor-pointer">
                                                                <span x-text="i.toString().padStart(2, '0')"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fw-medium">:</div>
                                            <div x-data="{open: false}" x-on:click.away="open = false" class="flex-grow-1 bg-secondary-subtle rounded">
                                                <div x-on:click="open = !open" class="py-1 fw-medium text-center cursor-pointer">
                                                    <span x-text="slot.end.mm || 'MM'"></span>
                                                </div>
                                                <div class="position-relative">
                                                    <div x-show="open" x-transition style="max-height:90px;"
                                                        class="position-absolute start-0 end-0 my-1 py-1 z-2 overflow-y-auto rounded border shadow-sm bg-secondary-subtle">
                                                        <template x-for="i in 59">
                                                            <div x-on:click="slot.end.mm = i.toString().padStart(2, '0'); open = false;"
                                                                class="px-2 fw-medium text-center cursor-pointer">
                                                                <span x-text="i.toString().padStart(2, '0')"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="day.enabled && !day.is24Hours" class="col-12 col-lg-1">
                                        <template x-if="slotIndex == 0">
                                            <button x-on:click="addTimingsHour(day)" type="button" class="btn btn-sm px-1 py-1 lh-1 btn-info text-white">
                                                <x-icons.material.add />
                                            </button>
                                        </template>
                                        <template x-if="slotIndex > 0">
                                            <button x-on:click="removeTimingsHour(day, slot)" type="button" class="btn btn-sm px-1 py-1 lh-1 btn-danger text-white">
                                                <x-icons.material.close />
                                            </button>
                                        </template>
                                    </div>
                                    <div x-show="day.enabled && day.is24Hours" class="col-12 col-lg-10">
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 mx-1 my-1 rounded bg-info-subtle text-black text-opacity-50">
                                            <x-icons.fa.sun />
                                            <span class="fw-semibold">Open 24 Hours</span>
                                        </div>
                                    </div>
                                    <div x-show="!day.enabled" class="col-12">
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 mx-1 my-1 rounded bg-secondary-subtle text-black text-opacity-50">
                                            <x-icons.fa.moon />
                                            <span class="fw-semibold">Closed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

