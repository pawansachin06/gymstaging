@props(['item' => null])

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-profile-and-cover-photo" aria-expanded="true" aria-controls="collapse-profile-and-cover-photo">
            <span class="fw-semibold">Profile & Cover Photo</span>
        </button>
    </h2>
    <div id="collapse-profile-and-cover-photo" class="accordion-collapse collapse show" data-bs-parent="#accordion-listing">
        <div class="accordion-body">
            hello there
        </div>
    </div>
</div>

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

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-contact-and-socials" aria-expanded="false" aria-controls="collapse-contact-and-socials">
            <span class="fw-semibold">Contact & Socials</span>
        </button>
    </h2>
    <div id="collapse-contact-and-socials" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body pt-0">
            <p class="text-center fw-medium">Make it easy for users to find you and connect with you.</p>
            <span class="fw-semibold mb-2 d-inline-block">Primary Contact</span>
            <div class="row mb-3 gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Website</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.globe /></span>
                        <input type="text" class="form-control" placeholder="https://yourwebsite.com" aria-label="Website" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Phone</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.phone /></span>
                        <input type="text" class="form-control" placeholder="07123 456789" aria-label="Phone" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Email</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.envelope /></span>
                        <input type="email" class="form-control shadow-sm" placeholder="name@example.com" aria-label="Email" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">WhatsApp</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.whatsapp /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="07123 456789" aria-label="WhatsApp" />
                    </div>
                </div>
            </div>
            <span class="fw-semibold mb-2 d-inline-block">Socials</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Instagram</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.instagram /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="https://instagram.com/yourhandle" aria-label="Instagram" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Tiktok</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.tiktok /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="https://tiktok.com/@yourhandle" aria-label="Tiktok" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Youtube</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.youtube /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="https://youtube.com/yourchannel" aria-label="Youtube" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Facebook</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.facebook /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="https://facebook.com/yourpage" aria-label="Facebook" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Linkedin</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.linkedin-in /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="https://linkedin.com/in/yourname" aria-label="Linkedin" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">X</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.x-twitter /></span>
                        <input type="text" class="form-control shadow-sm" placeholder="https://x.com/yourhandle" aria-label="X (Twitter)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-media-and-results" aria-expanded="false" aria-controls="collapse-media-and-results">
            <span class="fw-semibold">Media & Results</span>
        </button>
    </h2>
    <div id="collapse-media-and-results" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body">
            hello there
        </div>
    </div>
</div>

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

<div class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
    <h2 class="accordion-header">
        <button class="accordion-button px-3 py-2 shadow-none bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-about" aria-expanded="false" aria-controls="collapse-about">
            <span class="fw-semibold">About</span>
        </button>
    </h2>
    <div id="collapse-about" class="accordion-collapse collapse" data-bs-parent="#accordion-listing">
        <div class="accordion-body">
            hello there
        </div>
    </div>
</div>

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

