<x-front-layout>
    <section class="position-relative mb-4">
        <div class="d-none d-md-block position-absolute clip-ellipse-bottom top-0 left-0 right-0 bottom-0">
            <img src="https://images.unsplash.com/photo-1517964603305-11c0f6f66012?w=400&auto=format&fit=crop&q=60" class="w-100 h-100 object-fit-cover" />
            <div class="position-absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="container position-relative pt-4 pt-md-5 pb-md-5 text-center">
            <div class="d-none d-md-block">
                <h1 class="h1 fw-bold text-white">Get Listed</h1>
                <p class="mb-4 fw-medium text-white">
                    Tell us what kind of business you run.
                </p>
            </div>
            <div class="d-md-none">
                <h2 class="h1 fw-bold">Get Listed</h2>
                <p class="mb-0 fw-medium">
                    Tell us what kind of business you run.
                </p>
            </div>
        </div>
    </section>
    <section class="container mb-5">
        <div class="row gy-4 my-4 align-items-center">
            <div class="col-12 col-md-6">
                <div class="ratio ratio-16x9">
                    <video controls autoplay loop class="rounded-4">
                        <source src="/storage/static/intro.mp4" type="video/mp4" />
                        <track src="/storage/static/intro.vtt" kind="captions" srclang="en" label="English" default />
                    </video>
                </div>
            </div>
            <div x-data="prologue" class="col-12 col-md-6">
                <p class="mb-4 text-center fw-semibold">
                    Choose your business type so we can<br /> tailor your setup:
                </p>
                <div class="mb-2">
                    @foreach($services as $type => $group)
                        <div x-cloak x-show="step == 1">
                            <button type="button" x-on:click="onTypeChange('{{ $type }}')" class="mb-3 btn shadow rounded-pill fw-semibold w-100"
                                x-bind:class="[type === '{{ $type }}' ? 'btn-gradient' : 'border border-2']">
                                <span>
                                    List as {{ $type === 'organization' ? 'Facility / Club' : ucfirst($type) }}
                                </span>
                            </button>
                        </div>
                        <div x-cloak x-show="step == 2 && type == '{{ $type }}'">
                            <div class="d-flex flex-column gap-3">
                                @foreach($group as $service)
                                    <button type="button" x-on:click="onServiceChange('{{ $service->slug }}')" class="btn shadow rounded-pill fw-semibold"
                                        x-bind:class="[service == '{{ $service->slug }}' ? 'btn-gradient' : 'border border-2']">
                                        {{ $service->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <p x-show="step == 1" class="mb-4 text-center fw-semibold">
                    <a href="#joinExampleModal" data-bs-toggle="modal" data-bs-target="#joinExampleModal" class="link-info">
                        Which one am I? See Examples
                    </a>
                </p>
                <p x-show="step == 2" x-cloak class="mb-2 text-center fw-semibold">
                    <a href="#" x-on:click.prevent="goBack()" class="link-info">Go back</a>
                </p>
                <button type="button" x-on:click="goNext()" x-bind:disabled="starting" class="btn btn-gradient-dark w-100 position-relative px-5 fw-medium rounded-pill">
                    <span class="d-inline-block px-2" x-text="step == 2 ? 'Start' : 'Next'">Next</span>
                    <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                        <x-icons.rocket />
                    </span>
                </button>
            </div>
        </div>
    </section>
    <section class="container my-5">
        <h2 class="h4 mb-4 text-center fw-bold">
            Why list your business on GymSelect?
        </h2>
        <div class="row gy-3 text-center justify-content-center">
            @foreach($steps as $step)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="h-100 px-3 py-4 rounded-4 border border-light bg-white shadow-md">
                        <div class="d-inline-block px-1 py-1 bg-primary-gradient rounded-circle shadow-md mb-3"
                            style="width:56px;height:56px;">
                            <span class="d-inline-flex align-items-center justify-content-center w-100 h-100 bg-white h4 my-0 lh-1 fw-semibold rounded-circle">
                                <x-dynamic-component :component="$step['icon']" />
                            </span>
                        </div>
                        <h3 class="h5 mb-2 fw-bold">{{ $step['title'] }}</h3>
                        <p class="mb-0">{{ $step['content'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    
    <div class="modal fade" id="joinExampleModal" tabindex="-1" aria-labelledby="joinExampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body pb-2">
                    <p class="mb-4 h5 text-center fw-semibold" id="joinExampleModalLabel">
                        Find your category
                    </p>

                    <div class="text-center">
                        <button type="button" class="btn btn-link link-dark text-decoration-none fw-semibold" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                    <div class="position-absolute top-0 end-0 px-1 py-1">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>