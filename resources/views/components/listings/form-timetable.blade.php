@props(['item' => null])

<div x-bind:class="[completedSteps.includes('timetable') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-timetable" aria-expanded="false" aria-controls="collapse-timetable">
            <span class="fw-semibold">Classes & Timetable</span>
        </button>
    </h2>
    <div id="collapse-timetable" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="mb-1 text-center fw-medium">Show what classes you run and when.</p>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Upload a PDF</span>
                    <label class="mb-3 position-relative d-inline-flex align-items-center justify-content-between px-2 py-2 rounded-3 shadow bg-info text-white fw-semibold w-100 cursor-pointer">
                        <x-icons.fa.arrow-up-from-bracket />
                        <span>Upload timetable</span>
                        <span></span>
                        <input type="file" x-on:change="handleTimetableFile($event)" accept=".pdf,image/*" class="visually-hidden" />
                    </label>
                    <div x-show="timetableFile?.name?.length > 0">
                        <div class="position-relative d-inline-flex align-items-center justify-content-between px-3 fw-medium rounded-pill shadow w-100">
                            <span x-on:click="downloadTimetableFile()" class="flex-grow-1 d-inline-block py-1" x-text="timetableFile?.name"></span>
                            <button x-on:click="removeTimetableFile()" type="button"
                                class="btn btn-sm px-0 py-0 rounded-pill text-dark border-0 bg-white">
                                <x-icons.material.close />
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">And a link:</span>
                    <div class="z-1 mb-3 rounded-3 border-gradient user-select-none">
                        <input type="url" name="timetable_link" value="{{ $item->timetable_link }}" x-model.fill="timetableLink"
                            x-on:input.debounce.1000ms="checkStep('timetable')" placeholder="Enter url" class="form-control fw-medium border-0 shadow-none w-100" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>