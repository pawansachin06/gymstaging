@props(['item' => null])

<x-listings.form-profile-photo :item="$item" />

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-identity-and-niche" aria-expanded="false" aria-controls="collapse-identity-and-niche">
            <span class="fw-semibold">Identity & Niche</span>
        </button>
    </h2>
    <div id="collapse-identity-and-niche" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Define who you are, who you help, and what makes your coaching unique.</p>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold">Business / Coach Name:</span>
                    <input type="text" name="" class="form-control shadow-sm" />
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold">Category:</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold">Gender:</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold">Suitable For:</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Suitable For</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Age Groups</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Experience & Ability</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Accessibility & Additional Needs</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Goals Helped</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Body Transformation</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Performance & Health</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Lifestyle & Sustainability</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Focus Areas</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Strength & Conditioning</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Combat & Martial Arts</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Studio & Mind Body</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Raquet & Ball Sports</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Pick all that apply..</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Delivery Methods</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            In-Person (Gym)
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-listings.form-contact-and-socials :item="$item" />

<x-listings.form-location :item="$item" />

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient-primary">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-conversion-boosters" aria-expanded="false" aria-controls="collapse-conversion-boosters">
            <span class="fw-semibold">Conversion Boosters</span>
        </button>
    </h2>
    <div id="collapse-conversion-boosters" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Unlock high-impact tools to boost visibility and conversions</p>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Prime call to action (CTA)</span>
                    <p class="small">What action would you most like users to take?</p>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Preview</span>
                    <p class="small">How your CTA will appear.</p>
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

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-services-and-offers" aria-expanded="false" aria-controls="collapse-services-and-offers">
            <span class="fw-semibold">Services & Offers</span>
        </button>
    </h2>
    <div id="collapse-services-and-offers" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Showcase the services you provide and your available packages.</p>
            <span class="fw-semibold mb-2 d-inline-block">Services</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-semibold small">Programs & Plans</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-semibold small">Nutrition</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-semibold small">Technique & Skill</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-semibold small">Testing & Assessments</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-semibold small">Event Prep</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <hr class="my-4" />
            </div>
            <span class="fw-semibold mb-2 d-inline-block">Packages</span>
            <p class="small">Add any services, plans, or packages you’d like to showcase.</p>
        </div>
    </div>
</div>

<x-listings.form-media :item="$item" />

<x-listings.form-qualifications :item="$item" />

<x-listings.form-about :item="$item" />

<x-listings.form-tagging :item="$item" />



