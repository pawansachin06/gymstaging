@props(['item' => null])

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-timetable" aria-expanded="false" aria-controls="collapse-timetable">
            <span class="fw-semibold">Classes & Timetable</span>
        </button>
    </h2>
    <div id="collapse-timetable" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Show what classes you run and when.</p>
        </div>
    </div>
</div>