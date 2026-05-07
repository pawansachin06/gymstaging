<x-front-layout>
    <section x-data="listing" class="container my-4">
        <form action="{{ route('listings.update', $item) }}" x-on:submit.prevent="handleSubmit()" id="item-update-form" method="post">
            @method('PUT')
            <div class="mb-4 accordion accordion-flush" data-variant="{{ $serviceVariant }}" id="accordion-listing">
                <x-dynamic-component :component="'services.form-' . $serviceVariant" :item="$item" />
            </div>
            <p x-show="message.length" class="mb-2 small fw-medium text-center" x-text="message"></p>
            <div class="mb-5 row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">
                    <div class="d-flex flex-column gap-3">
                        <button type="submit" x-bind:disabled="updating" class="btn w-100 fw-semibold bg-white border-0 border-gradient rounded-pill shadow bg-gradient opacity-100">
                            <span>Save All Changes</span>
                            <span x-bind:class="[updating ? 'd-inline-flex' : 'd-none']" x-cloak
                                class="position-absolute top-0 bottom-0 end-0 px-2 align-items-center">
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            </span>
                        </button>
                        <button type="button" x-bind:disabled="updating" class="btn w-100 fw-semibold btn-dark rounded-pill shadow bg-gradient position-relative">
                            <span class="d-inline-block px-2">Publish Listing</span>
                            <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                                <x-icons.rocket />
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</x-front-layout>