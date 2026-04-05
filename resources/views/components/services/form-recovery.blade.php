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
                    <span class="fw-semibold">Category:</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Recovery Services</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Cold Therapy</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Heat & Light Therapy</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Compression & Circulation</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Specialist Equipment</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
            </div>
            <hr class="my-4" />
            <span class="fw-semibold mb-2 d-inline-block">Amenitites</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Access & Location</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Comfort & Facilities</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <span class="fw-medium small">Environment & Extras</span>
                    <select name="" class="form-select shadow-sm">
                        <option value="">Select which fits you best...</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<x-listings.form-contact-and-socials :item="$item" />

<x-listings.form-location :item="$item" />

<x-listings.form-hours :item="$item" />

<x-listings.form-media :item="$item" />

<x-listings.form-team :item="$item" />

<x-listings.form-about :item="$item" />

<x-listings.form-tagging :item="$item" />

