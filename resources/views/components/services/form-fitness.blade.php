@props(['item' => null])

<x-listings.form-profile-photo :item="$item" />

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-business-info" aria-expanded="false" aria-controls="collapse-business-info">
            <span class="fw-semibold">Business info</span>
        </button>
    </h2>
    <div id="collapse-business-info" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Tell users what you offer and when you’re open.</p>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold">Business Name:</span>
                    <input type="text" name="" class="form-control shadow-sm" />
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold">Provider type:</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Activities</span>
            <p class="small">Choose all activities your business offers.</p>
            <div class="mb-4 row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Combat & Martial Arts</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Strength & Conditioning</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Studio & Mind-Body</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Raquet & Ball Sports</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Outdoors & Clubs</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <span class="fw-semibold mb-2 d-inline-block">Featured Activity</span>
            <p class="small">Shown under your business name in search results</p>
            <div class="mb-4 row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Amenities</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">General Facilities</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Training Zones</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Wellness & Spa</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Accessibility</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Recovery Services</span>
            <div class="mb-4 row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Cold Therapy</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Heat & Light Therapy</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Compression & Circulation</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Specialist Equipment</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Access</span>
            <div class="mb-4 row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Gender</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Age</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<x-listings.form-contact-and-socials :item="$item" />

<x-listings.form-location :item="$item" />

<x-listings.form-hours :item="$item" />

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
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
        </div>
    </div>
</div>

<x-listings.form-media :item="$item" />

<x-listings.form-team :item="$item" />

<x-listings.form-timetable :item="$item" />

<x-listings.form-about :item="$item" />

<x-listings.form-tagging :item="$item" />



