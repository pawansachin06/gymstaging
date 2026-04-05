@props(['item' => null])

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-location" aria-expanded="false" aria-controls="collapse-location">
            <span class="fw-semibold">Location</span>
        </button>
    </h2>
    <div id="collapse-location" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Add your location and tag any training facilities your work from.</p>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Address</span>
                    <p class="small">Let clients know where they can find you. If you’re mobile or online, you can simply enter your city or the area you cover.</p>
                    <input type="text" name="" placeholder="Search location..." autocomplete="off" class="form-control shadow-sm" />
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-semibold mb-2 d-inline-block">Tag a gym, club or studio...</span>
                    <p class="small">If you train clients at a gym, club, or studio listed on GymSelect, tag them here.</p>
                    <input type="text" name="" placeholder="Search business name..." autocomplete="off" class="form-control shadow-sm" />
                    
                </div>
            </div>
        </div>
    </div>
</div>