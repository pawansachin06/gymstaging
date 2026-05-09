@props(['item' => null])

<div x-bind:class="[completedSteps.includes('conversion') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient-primary">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-conversion-boosters" aria-expanded="false" aria-controls="collapse-conversion-boosters">
            <span class="fw-semibold">Conversion Boosters</span>
        </button>
    </h2>
    <div id="collapse-conversion-boosters" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Unlock high-impact tools to boost visibility and conversions</p>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Prime call to action (CTA)</span>
                    <p class="mb-3 small">What action would you most like users to take?</p>

                    <div x-on:click.away="closeConversionTypes()" class="position-relative mb-3 user-select-none">
                        <button type="button" x-on:click="openConversionTypes()" x-bind:class="[conversionTypesOpen ? 'opacity-0' : '']"
                            class="z-1 px-0 py-0 border-0 shadow-sm rounded-3 border-gradient w-100">
                            <span class="d-inline-block px-3 py-2 text-center rounded-3 bg-white w-100 small">
                                <span x-bind:class="[conversion.type.length > 0 ? 'fw-semibold' : '']"
                                    x-text="conversionTitleFor(conversion.type)">Select Type</span>
                            </span>
                        </button>
                        <div x-show="conversionTypesOpen" x-transition
                            class="z-2 position-absolute w-100 start-0 top-0 end-0 rounded-3 shadow border-gradient">
                            <div class="rounded-3 bg-white">
                                <div class="px-3 py-2 text-center">
                                    <span class="small fw-medium">Select Type</span>
                                </div>
                                <template x-for="(convType, convTypeInx) in conversionTypes" x-bind:key="convTypeInx">
                                    <div x-on:click="handleConversionType(convType)" class="px-4 py-2 border-top">
                                        <span class="small" x-bind:class="[conversion.type === convType.value ? 'fw-semibold' : '']"
                                            x-text="convType.title"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="conversion.type?.length > 0" x-on:click.away="closeConversionLabels()" class="position-relative mb-3 user-select-none">
                        <button type="button" x-on:click="openConversionLabels()" x-bind:class="[conversionLabelsOpen ? 'opacity-0' : '']"
                            class="z-1 px-0 py-0 border-0 shadow-sm rounded-3 border-gradient w-100">
                            <span class="d-inline-block px-3 py-2 text-center rounded-3 bg-white w-100 small">
                                <span x-bind:class="[conversion.label.length > 0 ? 'fw-semibold' : '']"
                                    x-text="conversionLabelFor(conversion.label)">Select Button Text</span>
                            </span>
                        </button>
                        <div x-show="conversionLabelsOpen" x-transition
                            class="z-2 position-absolute w-100 start-0 top-0 end-0 rounded-3 shadow border-gradient">
                            <div class="rounded-3 bg-white">
                                <div class="px-3 py-2 text-center">
                                    <span class="small fw-medium">Select Button Text</span>
                                </div>
                                <template x-for="(convLabel, convLabelInx) in getConversionLabels()" x-bind:key="convLabelInx">
                                    <div x-on:click="handleConversionLabel(convLabel)" class="px-4 py-2 border-top">
                                        <span class="small" x-bind:class="[conversion.label === convLabel.value ? 'fw-semibold' : '']"
                                            x-text="convLabel.title"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="conversion.label === 'custom'" class="z-1 rounded-3 border-gradient mb-3">
                        <div class="rounded-3 bg-white">
                            <input type="text" x-model="conversion.title" max="25" placeholder="Enter Button Text"
                                class="form-control border-0 shadow-none w-100" />
                        </div>
                    </div>

                    <div x-show="conversion.label?.length > 0" class="z-1 rounded-3 border-gradient user-select-none">
                        <div x-show="['website', 'form', 'custom'].includes(conversion.type)" class="rounded-3 bg-white">
                            <input type="text" x-model="conversion.value" placeholder="Enter Url"
                                class="form-control border-0 shadow-none w-100" />
                        </div>
                        <div x-show="['email'].includes(conversion.type)" class="rounded-3 bg-white">
                            <input type="email" x-model="conversion.value" placeholder="Enter Email"
                                class="form-control border-0 shadow-none w-100" />
                        </div>
                        <div x-show="['call', 'whatsapp'].includes(conversion.type)" class="rounded-3 bg-white">
                            <div class="input-group">
                                <select x-model="conversion.prefix" class="form-select shadow-none" style="max-width:90px;">
                                    <option value="44">+44</option>
                                </select>
                                <input type="number" x-model="conversion.value" placeholder="Enter" class="form-control shadow-none" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="conversion" x-bind:value="JSON.stringify(conversion)" />
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Preview</span>
                    <p class="mb-4 small">How your CTA will appear.</p>
                    <div x-show="conversion.label?.length > 0" class="user-select-none">
                        <button type="button" class="btn btn-gradient-dark w-100 position-relative px-5 fw-medium rounded-pill opacity-100">
                            <span class="d-inline-block px-2" x-text="conversion.title"></span>
                        </button>
                    </div>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Perks</span>
            <p class="small">Add perks to engage users and boost your visibility & conversions.</p>
            <div class="row gy-3">
                <div class="col-12 col-md-6"></div>
                <div class="col-12 col-md-6"></div>
            </div>
        </div>
    </div>
</div>