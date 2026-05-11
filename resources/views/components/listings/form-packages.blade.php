@props(['item' => null])

<div x-bind:class="[completedSteps.includes('packages') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-services-and-offers" aria-expanded="false" aria-controls="collapse-services-and-offers">
            <span class="fw-semibold">Membership / Pricing</span>
        </button>
    </h2>
    <div id="collapse-services-and-offers" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Show your pricing options clearly so users can take action fast.</p>
            <span class="fw-semibold mb-2 d-inline-block">Packages</span>
            <p class="small">Add any services, plans, or packages you’d like to showcase.</p>

            <div class="row gx-5 gy-3">
                <div class="col-12 col-md-6">
                    <div id="item-packages">
                        <template x-for="package in packages" x-bind:key="package.id">
                            <div x-data="{open: false}" style="min-height:56px;"
                                class="position-relative mb-3 z-1 border-gradient rounded-3 shadow">
                                <div class="px-3 py-2 d-flex align-items-center gap-2 rounded-3 bg-white">
                                    <div x-on:click="open = !open" class="flex-grow-1 pe-3 cursor-pointer">
                                        <div>
                                            <p class="mb-0 fw-semibold" x-text="package.title"></p>
                                            <p class="mb-2 fw-semibold small text-info" x-text="package.price"></p>
                                            <div x-show="open">
                                                <ol class="small">
                                                    <template x-for="packageBenefit in package.benefits" x-bind:key="packageBenefit.id">
                                                        <li x-text="packageBenefit.title"></li>
                                                    </template>
                                                </ol>
                                                <p class="mb-0 small" x-text="package.action.value"></p>
                                            </div>
                                        </div>
                                        <div class="position-absolute top-0 end-0 px-2 py-3">
                                            <x-icons.material.keyboard-arrow-up x-show="open" />
                                            <x-icons.material.keyboard-arrow-down x-show="!open" />
                                        </div>
                                    </div>
                                    <div x-on:click="removePackage(package)" class="z-1 position-absolute top-0 start-100 translate-middle">
                                        <button type="button" class="btn btn-sm px-0 py-0 rounded-pill border-2 text-secondary border-secondary bg-white">
                                            <x-icons.material.close />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="packages.length == 0" x-cloak>
                            <div class="position-relative px-3 py-2 d-flex align-items-center gap-2 border border-light rounded-3 shadow">
                                <p class="mb-0">Create Packages</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <button type="button" x-on:click="openPackage()" x-show="!packageOpen"
                        class="z-1 mb-2 px-0 py-0 border-0 shadow-sm rounded-3 border-gradient w-100">
                        <span class="d-inline-block px-2 py-4 text-center rounded-3 bg-white w-100">
                            <span class="fw-semibold">+ Add Package</span>
                        </span>
                    </button>

                    <template x-if="packageOpen">
                        <div class="px-3 py-3 position-relative border border-light rounded-3 shadow">
                            <span class="d-inline-block mb-1 small fw-semibold">
                                Name of Service or Product:
                            </span>
                            <div class="z-1 mb-3 rounded-3 border-gradient user-select-none">
                                <input type="text" x-model="newPackage.title" placeholder="e.g. Monthly Gym Membership, Day Pass..." class="form-control border-0 shadow-none w-100" />
                            </div>
                            <span class="d-inline-block mb-1 small fw-semibold">
                                Add your price or price range:
                            </span>
                            <div class="z-1 mb-3 rounded-3 border-gradient user-select-none">
                                <input type="text" x-model="newPackage.price" placeholder="e.g. £25/month, £6 day pass, or £200/year" class="form-control border-0 shadow-none w-100" />
                            </div>
                            <div class="d-flex gap-2 mb-1">
                                <div class="flex-shrink-0" style="width:32px;"></div>
                                <div class="fw-semibold small">
                                    <span>Whats included:</span>
                                </div>
                            </div>
                            <template x-for="packageBenefit in newPackage?.benefits || []" x-bind:key="packageBenefit.id">
                                <div class="d-flex gap-2 mb-3 align-items-center">
                                    <div class="flex-shrink-0 px-1 py-1">
                                        <picture>
                                            <img src="/assets/img/icons/tick-gradient.png" width="24px" height="24px" />
                                        </picture>
                                    </div>
                                    <div class="position-relative flex-grow-1">
                                        <div class="z-1 rounded-3 border-gradient">
                                            <input type="text" x-model="packageBenefit.title" placeholder="e.g." class="form-control shadow-none w-100" />
                                        </div>
                                        <div class="z-1 position-absolute top-0 start-100 translate-middle">
                                            <button x-on:click="removePackageBenefit(packageBenefit)" type="button"
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
                                    <button x-on:click="addPackageBenefit()" type="button" class="z-1 btn border-gradient rounded-3 w-100 text-white">
                                        <x-icons.material.add />
                                    </button>
                                </div>
                            </div>
                            <p class="mb-2 fw-semibold small">
                                <span>Add a call to action:</span>
                            </p>
                            <div x-on:click.away="closePackageAction()" class="position-relative mb-3 user-select-none">
                                <button type="button" x-on:click="openPackageAction()" x-bind:class="[packageActionOpen ? 'opacity-0' : '']"
                                    class="z-1 px-0 py-0 border-0 shadow-sm rounded-3 border-gradient w-100">
                                    <span class="d-inline-block px-3 py-2 text-center rounded-3 bg-white w-100 small">
                                        <span x-bind:class="[newPackage?.action?.type?.length > 0 ? 'fw-semibold' : '']"
                                            x-text="conversionTitleFor(newPackage?.action?.type)">Select Type</span>
                                    </span>
                                    <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                        <x-icons.material.keyboard-arrow-down />
                                    </span>
                                </button>
                                <div x-show="packageActionOpen" x-transition
                                    class="z-2 position-absolute w-100 start-0 top-0 end-0 rounded-3 shadow border-gradient">
                                    <div class="rounded-3 bg-white">
                                        <div x-on:click="closePackageAction()" class="position-relative px-3 py-2 text-center cursor-pointer">
                                            <span class="small fw-medium">Select Type</span>
                                            <span class="position-absolute top-0 end-0 bottom-0 px-1 d-inline-flex align-items-center">
                                                <x-icons.material.keyboard-arrow-up />
                                            </span>
                                        </div>
                                        <template x-for="(convType, convTypeInx) in conversionTypes" x-bind:key="convTypeInx">
                                            <div x-on:click="handlePackageActionType(convType)" class="px-4 py-2 border-top cursor-pointer">
                                                <span class="small" x-bind:class="[newPackage?.action?.type === convType.value ? 'fw-semibold' : '']"
                                                    x-text="convType.title"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <template x-if="!!newPackage">
                                <div class="mb-3 z-1 rounded-3 border-gradient user-select-none">
                                    <div x-show="['website', 'form', 'custom'].includes(newPackage?.action.type)" class="rounded-3 bg-white">
                                        <input type="text" x-model="newPackage.action.value" placeholder="Enter Url"
                                            class="form-control border-0 shadow-none w-100" />
                                    </div>
                                    <div x-show="['email'].includes(newPackage.action.type)" class="rounded-3 bg-white">
                                        <input type="email" x-model="newPackage.action.value" placeholder="Enter Email"
                                            class="form-control border-0 shadow-none w-100" />
                                    </div>
                                    <div x-show="['call', 'whatsapp'].includes(newPackage?.action?.type)" class="rounded-3 bg-white">
                                        <div class="input-group">
                                            <select x-model="newPackage.action.prefix" class="form-select shadow-none" style="max-width:90px;">
                                                <option value="44">+44</option>
                                            </select>
                                            <input type="text" x-model="newPackage.action.value" placeholder="Enter" class="form-control shadow-none" />
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <button x-on:click="savePackage()" type="button" class="btn btn-dark rounded-3 w-100 fw-semibold">
                                <span>Save Package</span>
                            </button>
                            <div class="z-1 position-absolute top-0 start-100 translate-middle">
                                <button x-on:click="closePackage()" type="button"
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