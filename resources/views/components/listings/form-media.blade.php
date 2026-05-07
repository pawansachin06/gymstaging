@props(['item' => null])

<div x-bind:class="[completedSteps.includes('media') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-media" aria-expanded="false" aria-controls="collapse-media">
            <span class="fw-semibold">Media & Results</span>
        </button>
    </h2>
    <div id="collapse-media" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium user-select-none">
                Show your facility, your community and the results your members achieve.
            </p>
            <span class="fw-semibold mb-2 d-inline-block">Media:</span>
            <div class="row gx-2 gy-2 mb-4">
                <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                    <div class="position-relative rounded-3 bg-info text-white">
                        <div class="ratio ratio-16x9"></div>
                        <label for="item-media" class="position-absolute top-0 bottom-0 start-0 end-0 d-inline-flex align-items-center justify-content-center cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                <path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/>
                            </svg>
                            <input type="file" id="item-media" multiple x-on:change="handleMediaFiles($event)" accept="image/*" class="visually-hidden" />
                        </label>
                    </div>
                </div>
                <template x-for="mediaFile in mediaFiles" x-bind:key="mediaFile.id">
                    <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="position-relative">
                            <div class="ratio ratio-16x9">
                                <img x-bind:src="getFileUrl(mediaFile)" class="rounded-3 object-fit-cover" />
                            </div>
                            <div class="position-absolute top-0 end-0">
                                <button x-on:click="removeMediaFile(mediaFile)" type="button" class="btn btn-sm btn-danger px-1 py-1">
                                    <x-icons.material.close />
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <span class="fw-semibold mb-2 d-inline-block">Member Transformations:</span>
            <div class="row gx-2 gy-2 mb-4">
                <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                    <div class="position-relative rounded-3 bg-info text-white">
                        <div class="ratio ratio-1x1"></div>
                        <label for="item-transformations" class="position-absolute top-0 bottom-0 start-0 end-0 d-inline-flex align-items-center justify-content-center cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                <path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/>
                            </svg>
                            <input type="file" id="item-transformations" multiple x-on:change="handleTransformationFiles($event)" accept="image/*" class="visually-hidden" />
                        </label>
                    </div>
                </div>
                <template x-for="transformationFile in transformationFiles" x-bind:key="transformationFile.id">
                    <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                        <div class="position-relative">
                            <div class="ratio ratio-1x1">
                                <img x-bind:src="getFileUrl(transformationFile)" class="rounded-3 object-fit-cover" />
                            </div>
                            <div class="position-absolute top-0 end-0">
                                <button x-on:click="removeTransformationFile(transformationFile)" type="button" class="btn btn-sm btn-danger px-1 py-1">
                                    <x-icons.material.close />
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>