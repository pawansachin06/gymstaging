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

            <x-listings.form-packages-content :item="$item" />

        </div>
    </div>
</div>