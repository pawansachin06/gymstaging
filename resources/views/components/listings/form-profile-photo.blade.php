@props(['item' => null])

<div x-bind:class="[completedSteps.includes('profile-and-cover-photo') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-profile-and-cover-photo" aria-expanded="true" aria-controls="collapse-profile-and-cover-photo">
            <span class="fw-semibold user-select-none">Profile & Cover Photo</span>
        </button>
    </h2>
    <div id="collapse-profile-and-cover-photo" class="accordion-collapse collapse show" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium user-select-none">
                Add photos that make your business stand out to visitors.
            </p>
            <span class="fw-semibold mb-2 d-inline-block">Profile Photo</span>
            <div class="position-relative mb-4 rounded-circle bg-info text-white"
                style="width:100px;height:100px;">
                <picture class="position-relative">
                    <img src="{{ !empty($item->profile_image) ? $item->profile_image_url : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}"
                        alt="" class="item-profile_image w-100 h-100 object-fit-cover rounded-circle" />
                </picture>
                <label for="item-profile_image" class="position-absolute top-0 bottom-0 start-0 end-0 d-inline-flex align-items-center justify-content-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/>
                    </svg>
                    <input type="file" id="item-profile_image" name="profile_image_file" x-on:change="checkSteps()" accept="image/*" data-target=".item-profile_image" data-js="input-image-preview" class="visually-hidden" />
                </label>
            </div>
            <span class="fw-semibold mb-2 d-inline-block">Cover Photo</span>
            <div class="position-relative mb-3 rounded-3 bg-info text-white"
                style="width:200px;height:100px;">
                <picture class="position-relative">
                    <img src="{{ !empty($item->cover_image) ? $item->cover_image_url : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}"
                        alt="" class="item-cover_image w-100 h-100 object-fit-cover rounded-3" />
                </picture>
                <label for="item-cover_image" class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/>
                    </svg>
                    <input type="file" id="item-cover_image" name="cover_image_file" x-on:change="checkSteps()" accept="image/*" data-target=".item-cover_image" data-js="input-image-preview" class="visually-hidden" />
                </label>
            </div>
        </div>
    </div>
</div>

