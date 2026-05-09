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
                            <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                <x-icons.material.keyboard-arrow-down />
                            </span>
                        </button>
                        <div x-show="conversionTypesOpen" x-transition
                            class="z-2 position-absolute w-100 start-0 top-0 end-0 rounded-3 shadow border-gradient">
                            <div class="rounded-3 bg-white">
                                <div x-on:click="closeConversionTypes()" class="position-relative px-3 py-2 text-center cursor-pointer">
                                    <span class="small fw-medium">Select Type</span>
                                    <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                        <x-icons.material.keyboard-arrow-up />
                                    </span>
                                </div>
                                <template x-for="(convType, convTypeInx) in conversionTypes" x-bind:key="convTypeInx">
                                    <div x-on:click="handleConversionType(convType)" class="px-4 py-2 border-top cursor-pointer">
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
                            <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                <x-icons.material.keyboard-arrow-down />
                            </span>
                        </button>
                        <div x-show="conversionLabelsOpen" x-transition
                            class="z-2 position-absolute w-100 start-0 top-0 end-0 rounded-3 shadow border-gradient">
                            <div class="rounded-3 bg-white">
                                <div x-on:click="closeConversionLabels()" class="position-relative px-3 py-2 text-center cursor-pointer">
                                    <span class="small fw-medium">Select Button Text</span>
                                    <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                        <x-icons.material.keyboard-arrow-up />
                                    </span>
                                </div>
                                <template x-for="(convLabel, convLabelInx) in getConversionLabels()" x-bind:key="convLabelInx">
                                    <div x-on:click="handleConversionLabel(convLabel)" class="px-4 py-2 border-top cursor-pointer">
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
                                <input type="text" x-model="conversion.value" placeholder="Enter" class="form-control shadow-none" />
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
            <div class="row gx-5 gy-3">
                <div class="col-12 col-md-6">
                    <div id="item-perks">
                        <template x-for="perk in perks" x-bind:key="perk.id">
                            <div x-data="{open: false}" class="position-relative mb-3 px-3 py-2 d-flex align-items-center gap-2 border border-light rounded-3 shadow">
                                <div class="flex-shrink-0 align-self-start">
                                    <picture>
                                        <img src="/assets/img/icons/perk-circle.png" width="42px" height="42px" />
                                    </picture>
                                </div>
                                <div x-on:click="open = !open" class="flex-grow-1 pe-3 cursor-pointer">
                                    <div>
                                        <p class="mb-0 fw-semibold" x-text="perk.title"></p>
                                        <div x-show="open">
                                            <ol class="small">
                                                <template x-for="perkBenefit in perk.benefits" x-bind:key="perkBenefit.id">
                                                    <li x-text="perkBenefit.title"></li>
                                                </template>
                                            </ol>
                                            <ol class="small">
                                                <template x-for="perkStep in perk.steps" x-bind:key="perkStep.id">
                                                    <li x-text="perkStep.title"></li>
                                                </template>
                                            </ol>
                                            <p class="mb-0 small" x-text="perk.action.value"></p>
                                        </div>
                                    </div>
                                    <div class="position-absolute top-0 end-0 px-2 py-3">
                                        <x-icons.material.keyboard-arrow-up x-show="open" />
                                        <x-icons.material.keyboard-arrow-down x-show="!open" />
                                    </div>
                                </div>
                                <div x-on:click="removePerk(perk)" class="z-1 position-absolute top-0 start-100 translate-middle">
                                    <button type="button" class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                        <x-icons.material.close />
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div x-show="perks.length == 0" x-cloak>
                            <div class="position-relative px-3 py-2 d-flex align-items-center gap-2 border border-light rounded-3 shadow">
                                <p class="mb-0">Create Perks</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <button type="button" x-on:click="openPerk()" x-show="!perkOpen"
                        class="z-1 mb-2 px-0 py-0 border-0 shadow-sm rounded-3 border-gradient w-100">
                        <span class="d-inline-block px-2 py-4 text-center rounded-3 bg-white w-100">
                            <span class="fw-semibold">+ Add Perk</span>
                        </span>
                    </button>

                    <template x-if="perkOpen">
                        <div class="px-3 py-3 position-relative border border-light rounded-3 shadow">
                            <span class="d-inline-block mb-1 small fw-semibold">What is the perk you'd like to offer?</span>
                            <div class="z-1 mb-3 rounded-3 border-gradient user-select-none">
                                <input type="text" x-model="newPerk.title" placeholder="e.g. 10% of all memberships" class="form-control border-0 shadow-none w-100" />
                            </div>
                            <div class="d-flex gap-2 mb-1">
                                <div class="flex-shrink-0" style="width:32px;"></div>
                                <div class="fw-semibold small">
                                    <span>Whats included:</span>
                                </div>
                            </div>
                            <template x-for="perkBenefit in newPerk?.benefits || []" x-bind:key="perkBenefit.id">
                                <div class="d-flex gap-2 mb-3 align-items-center">
                                    <div class="flex-shrink-0 px-1 py-1">
                                        <picture>
                                            <img src="/assets/img/icons/tick-gradient.png" width="24px" height="24px" />
                                        </picture>
                                    </div>
                                    <div class="position-relative flex-grow-1">
                                        <div class="z-1 rounded-3 border-gradient">
                                            <input type="text" x-model="perkBenefit.title" placeholder="e.g." class="form-control shadow-none w-100" />
                                        </div>
                                        <div class="z-1 position-absolute top-0 start-100 translate-middle">
                                            <button x-on:click="removePerkBenefit(perkBenefit)" type="button"
                                                class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                                <x-icons.material.close />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div class="mb-3 d-flex gap-2">
                                <div class="flex-shrink-0" style="width:32px;"></div>
                                <div class="flex-grow-1">
                                    <button x-on:click="addPerkBenefit()" type="button" class="z-1 btn border-gradient rounded-3 w-100 text-white">
                                        <x-icons.material.add />
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mb-1">
                                <div class="flex-shrink-0" style="width:32px;"></div>
                                <div class="fw-semibold small">
                                    <span>How to redeem:</span>
                                </div>
                            </div>
                            <template x-for="(perkStep, perkStepInx) in newPerk?.steps || []" x-bind:key="perkStep.id">
                                <div class="d-flex gap-2 mb-3 align-items-center">
                                    <div class="flex-shrink-0 px-1 py-1">
                                        <picture x-data="{perkStepImg: perkStepInx + 1}">
                                            <img x-bind:src="'/assets/img/icons/' + perkStepImg + '.png'" width="24px" height="24px" />
                                        </picture>
                                    </div>
                                    <div class="position-relative flex-grow-1">
                                        <div class="z-1 rounded-3 border-gradient">
                                            <input type="text" x-model="perkStep.title" placeholder="e.g." class="form-control shadow-none w-100" />
                                        </div>
                                        <div class="z-1 position-absolute top-0 start-100 translate-middle">
                                            <button x-on:click="removePerkStep(perkStep)" type="button" class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                                <x-icons.material.close />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div class="mb-3 d-flex gap-2">
                                <div class="flex-shrink-0" style="width:32px;"></div>
                                <div class="flex-grow-1">
                                    <button x-on:click="addPerkStep()" type="button" class="z-1 btn bg-black rounded-3 w-100 text-white">
                                        <x-icons.material.add />
                                    </button>
                                </div>
                            </div>
                            <p class="mb-2 fw-semibold small">
                                <span>How will they redeem this?</span>
                            </p>
                            <div x-on:click.away="closePerkAction()" class="position-relative mb-3 user-select-none">
                                <button type="button" x-on:click="openPerkAction()" x-bind:class="[perkActionOpen ? 'opacity-0' : '']"
                                    class="z-1 px-0 py-0 border-0 shadow-sm rounded-3 border-gradient w-100">
                                    <span class="d-inline-block px-3 py-2 text-center rounded-3 bg-white w-100 small">
                                        <span x-bind:class="[newPerk?.action?.type?.length > 0 ? 'fw-semibold' : '']"
                                            x-text="conversionTitleFor(newPerk?.action?.type)">Select Type</span>
                                    </span>
                                    <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                        <x-icons.material.keyboard-arrow-down />
                                    </span>
                                </button>
                                <div x-show="perkActionOpen" x-transition
                                    class="z-2 position-absolute w-100 start-0 top-0 end-0 rounded-3 shadow border-gradient">
                                    <div class="rounded-3 bg-white">
                                        <div x-on:click="closePerkAction()" class="position-relative px-3 py-2 text-center cursor-pointer">
                                            <span class="small fw-medium">Select Type</span>
                                            <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                                <x-icons.material.keyboard-arrow-up />
                                            </span>
                                        </div>
                                        <template x-for="(convType, convTypeInx) in conversionTypes" x-bind:key="convTypeInx">
                                            <div x-on:click="handlePerkActionType(convType)" class="px-4 py-2 border-top cursor-pointer">
                                                <span class="small" x-bind:class="[newPerk?.action?.type === convType.value ? 'fw-semibold' : '']"
                                                    x-text="convType.title"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <template x-if="!!newPerk">
                                <div class="mb-3 z-1 rounded-3 border-gradient user-select-none">
                                    <div x-show="['website', 'form', 'custom'].includes(newPerk?.action.type)" class="rounded-3 bg-white">
                                        <input type="text" x-model="newPerk.action.value" placeholder="Enter Url"
                                            class="form-control border-0 shadow-none w-100" />
                                    </div>
                                    <div x-show="['email'].includes(newPerk.action.type)" class="rounded-3 bg-white">
                                        <input type="email" x-model="newPerk.action.value" placeholder="Enter Email"
                                            class="form-control border-0 shadow-none w-100" />
                                    </div>
                                    <div x-show="['call', 'whatsapp'].includes(newPerk?.action?.type)" class="rounded-3 bg-white">
                                        <div class="input-group">
                                            <select x-model="newPerk.action.prefix" class="form-select shadow-none" style="max-width:90px;">
                                                <option value="44">+44</option>
                                            </select>
                                            <input type="text" x-model="newPerk.action.value" placeholder="Enter" class="form-control shadow-none" />
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <button x-on:click="savePerk()" type="button" class="btn btn-dark rounded-3 w-100 fw-semibold">
                                <span>Save Perk</span>
                            </button>
                            <div class="z-1 position-absolute top-0 start-100 translate-middle">
                                <button x-on:click="closePerk()" type="button"
                                    class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                    <x-icons.material.close />
                                </button>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>
</div>