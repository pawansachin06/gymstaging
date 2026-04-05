@props(['item' => null])

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient-primary">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-tagging-permissions" aria-expanded="false" aria-controls="collapse-tagging-permissions">
            <span class="fw-semibold">Tagging Permissions</span>
        </button>
    </h2>
    <div id="collapse-tagging-permissions" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="small text-center">Allow users to feature you on their listings and let users tag you in reviews.</p>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="ui-segmented">
                        <input type="radio" id="listing-tagging-off" name="taggable" value="off" checked />
                        <input type="radio" id="listing-tagging-on" name="taggable" value="on" />
                        <div class="ui-segmented-track fw-medium">
                            <div class="ui-segmented-thumb"></div>
                            <label for="listing-tagging-off">Off</label>
                            <label for="listing-tagging-on">On</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>