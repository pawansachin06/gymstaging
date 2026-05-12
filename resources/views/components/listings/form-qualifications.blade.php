@props(['item' => null])

<div x-bind:class="[completedSteps.includes('qualifications') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-credentials" aria-expanded="false" aria-controls="collapse-credentials">
            <span class="fw-semibold">Credentials</span>
        </button>
    </h2>
    <div id="collapse-credentials" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <div class="text-center">
                <span class="fw-semibold mb-2 d-inline-block">Qualifications</span>
                <p class="small">Add your qualifications. Upload evidence if you’d like them to be verified.</p>
            </div>
            <div class="mx-auto" style="max-width:500px;">
                <template x-for="qualification in qualifications" x-bind:key="qualification.id">
                    <div class="mb-3 d-flex align-items-center gap-2 px-1 py-1 position-relative border border-dark rounded-3 shadow-sm bg-white">
                        <div class="flex-shrink-0">
                            <picture>
                                <img x-bind:src="'/assets/img/icons/qualification-' + qualification.status + '.png'"
                                    width="28px" height="28px" />
                            </picture>
                        </div>
                        <div class="flex-grow-1 text-truncate text-center fw-semibold">
                            <span x-text="qualification.name"></span>
                        </div>
                        <div style="width:28px;"></div>
                        <div class="z-1 position-absolute top-0 start-100 translate-middle">
                            <button x-on:click="removeQualification(qualification)" type="button"
                                class="px-0 py-0 border border-2 border-secondary rounded-pill bg-white text-secondary">
                                <x-icons.material.close />
                            </button>
                        </div>
                    </div>
                </template>
                <div class="row gx-2 gy-2">
                    <div class="col-12" x-show="!newQualification.open">
                        <button type="button" x-on:click="newQualification.open = true"
                            class="d-inline-flex justify-content-center px-1 py-2 fw-medium border-0 rounded-3 bg-info text-white w-100">
                            <span>Add Qualification</span>
                        </button>
                    </div>
                    <div class="col-12 col-md-8" x-show="newQualification.open">
                        <input type="text" x-model="newQualification.name" placeholder="Qualification Name" class="form-control fw-medium border-2 border-info w-100" />
                        <div x-text="newQualification.file?.name" class="text-truncate small"></div>
                    </div>
                    <div class="col-12 col-md-4" x-show="newQualification.open">
                        <label class="cursor-pointer d-inline-flex px-3 py-2 align-items-center justify-content-center gap-2 fw-medium border-0 rounded-3 bg-info text-white w-100">
                            <input type="file" x-on:change="handleQualificationFile($event)" accept=".pdf,image/*" class="visually-hidden" />
                            <x-icons.fa.arrow-up-from-bracket />
                            <span>Add Proof</span>
                        </label>
                    </div>
                    <div class="col-12" x-show="newQualification.open">
                        <div class="form-check">
                            <input class="form-check-input border-dark" type="checkbox" x-model="newQualification.consent" id="qualifications-consent" />
                            <label class="form-check-label small fw-medium user-select-none lh-sm" for="qualifications-consent">
                                I confirm that all qualifications and any uploaded documents are accurate and genuine.
                            </label>
                        </div>
                    </div>
                    <div class="col-12 px-5" x-show="newQualification.open">
                        <button type="button" x-on:click="addQualification()"
                            class="d-inline-flex justify-content-center px-1 py-2 fw-medium border-0 rounded-3 bg-info text-white w-100">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
            <hr class="my-4" />
            <div class="text-center">
                <span class="fw-semibold mb-2 d-inline-block">Professional Memberships</span>
                <p class="small">Add any industry memberships or affiliations. You can also include a link to your public member profile (optional).</p>
            </div>

        </div>
    </div>
</div>