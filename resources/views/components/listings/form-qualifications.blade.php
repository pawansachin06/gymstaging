@props(['item' => null])

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
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
            <hr class="my-4" />
            <div class="text-center">
                <span class="fw-semibold mb-2 d-inline-block">Professional Memberships</span>
                <p class="small">Add any industry memberships or affiliations. You can also include a link to your public member profile (optional).</p>
            </div>

        </div>
    </div>
</div>