@props(['item' => null])

<div x-bind:class="[completedSteps.includes('contact-and-socials') ? 'active' : '']"
    class="accordion-item mb-3 shadow rounded-4 border-0 border-gradient">
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
                        <input type="text" name="ctas[site][value]" value="{{ data_get($item, 'ctas.site.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control" placeholder="https://yourwebsite.com" aria-label="Website" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Phone</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.phone /></span>
                        <select class="form-select" style="max-width:90px;">
                            <option value="44" selected>+44</option>
                        </select>
                        <input type="text" name="ctas[call][value]" value="{{ data_get($item, 'ctas.call.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control" placeholder="07123 456789" aria-label="Phone" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Email</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.envelope /></span>
                        <input type="email" name="ctas[email][value]" value="{{ data_get($item, 'ctas.email.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="name@example.com" aria-label="Email" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">WhatsApp</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.whatsapp /></span>
                        <select name="ctas[whatsapp][code]" class="form-select" style="max-width:90px;">
                            <option value="44" selected>+44</option>
                        </select>
                        <input type="text" name="ctas[whatsapp][value]" value="{{ data_get($item, 'ctas.whatsapp.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="07123 456789" aria-label="WhatsApp" />
                    </div>
                </div>
            </div>
            <span class="fw-semibold mb-2 d-inline-block">Socials</span>
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Instagram</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.instagram /></span>
                        <input type="text" name="ctas[instagram][value]" value="{{ data_get($item, 'ctas.instagram.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="https://instagram.com/yourhandle" aria-label="Instagram" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Tiktok</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.tiktok /></span>
                        <input type="text" name="ctas[tiktok][value]" value="{{ data_get($item, 'ctas.tiktok.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="https://tiktok.com/@yourhandle" aria-label="Tiktok" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Youtube</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.youtube /></span>
                        <input type="text" name="ctas[youtube][value]" value="{{ data_get($item, 'ctas.youtube.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="https://youtube.com/yourchannel" aria-label="Youtube" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Facebook</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.facebook /></span>
                        <input type="text" name="ctas[facebook][value]" value="{{ data_get($item, 'ctas.facebook.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="https://facebook.com/yourpage" aria-label="Facebook" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">Linkedin</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.linkedin-in /></span>
                        <input type="text" name="ctas[linkedin][value]" value="{{ data_get($item, 'ctas.linkedin.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="https://linkedin.com/in/yourname" aria-label="Linkedin" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <span class="fw-medium small">X</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><x-icons.x-twitter /></span>
                        <input type="text" name="ctas[twitter][value]" value="{{ data_get($item, 'ctas.twitter.value') }}"
                            x-on:input.debounce.1000ms="checkStep('contact-and-socials')"
                            class="form-control shadow-sm" placeholder="https://x.com/yourhandle" aria-label="X (Twitter)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

