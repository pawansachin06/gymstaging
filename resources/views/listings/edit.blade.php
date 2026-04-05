<x-front-layout>
    <section class="container my-4">
        <form action="" method="post">
            <div class="mb-4 accordion accordion-flush" id="accordion-listing">

                <x-dynamic-component :component="'services.form-' . $serviceVariant" :item="$item" />

            </div>
            <div class="mb-5 row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">
                    <div class="d-flex flex-column gap-3">
                        <button type="submit" class="btn w-100 fw-semibold bg-white border-0 border-gradient rounded-pill shadow bg-gradient">
                            <span>Save All Changes</span>
                        </button>
                        <button type="button" class="btn w-100 fw-semibold btn-dark rounded-pill shadow bg-gradient position-relative">
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