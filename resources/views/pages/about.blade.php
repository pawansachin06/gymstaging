<x-front-layout>

    <section class="position-relative mb-4">
        <div class="d-none d-md-block position-absolute clip-ellipse-bottom top-0 left-0 right-0 bottom-0">
            <img src="https://images.unsplash.com/photo-1517964603305-11c0f6f66012?w=400&auto=format&fit=crop&q=60" class="w-100 h-100 object-fit-cover" />
            <div class="position-absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="container position-relative pt-4 pt-md-5 pb-md-5 text-center">
            <div class="d-none d-md-block">
                <h1 class="h1 fw-bold text-white">Fitness Connected</h1>
                <p class="mb-4 fw-medium text-white">
                    Discover gyms, coaches, clinics and more - all in one place.
                </p>
            </div>
            <div class="d-md-none">
                <h2 class="h1 fw-bold">Fitness Connected</h2>
                <p class="mb-0 fw-medium">
                    Discover gyms, coaches, clinics and more - all in one place.
                </p>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="d-none pt-4 d-md-flex row justify-content-center">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="gap-2 d-flex flex-column flex-sm-row justify-content-center align-items-center">
                    <a href="" class="btn btn-gradient w-100 link-dark position-relative px-5 fw-medium rounded-pill">
                        <span class="d-inline-block px-2">Explore GymSelect</span>
                        <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                            <x-icons.rocket />
                        </span>
                    </a>
                    <a href="" class="btn w-100 fw-medium rounded-pill">
                        List your business →
                    </a>
                </div>
            </div>
        </div>
        <div class="row gy-4 my-4">
            <div class="col-12 col-md-6">
                <div class="ratio ratio-16x9">
                    <video controls autoplay loop class="rounded-4">
                        <source src="/storage/static/intro.mp4" type="video/mp4" />
                        <track src="/storage/static/intro.vtt" kind="captions" srclang="en" label="English" default />
                    </video>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="video-contents-bg px-md-4 py-md-4 h-100 rounded-4">
                    <h2 class="h2 mb-3 fw-bold">What is GymSelect?</h2>
                    <p class="mb-3 fw-medium">GymSelect brings trusted health and fitness services into one place.</p>
                    <p class="mb-3 fw-medium">Search by location, compare listings, unlock exclusive perks, and leave reviews with a free account.</p>
                    <p class="mb-0 fw-medium">
                        Not a member? <a href="/join" class="text-decoration-none">Create a free account →</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="gap-2 d-flex flex-column flex-sm-row d-md-none justify-content-center align-items-center">
            <a href="" class="btn btn-gradient w-100 link-dark position-relative px-5 fw-medium rounded-pill">
                <span class="d-inline-block px-2">Explore GymSelect</span>
                <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                    <x-icons.rocket />
                </span>
            </a>
            <a href="" class="btn w-100 fw-medium rounded-pill">
                List your business →
            </a>
        </div>
    </section>
    
    <section class="container my-5">
        <h2 class="h4 mb-4 text-center fw-bold">
            How GymSelect works
        </h2>
        <div class="row gy-3 text-center justify-content-center">
            @foreach($steps as $step)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="h-100 px-3 py-4 rounded-4 border border-light bg-white shadow-md">
                        <div class="d-inline-block px-1 py-1 bg-primary-gradient rounded-circle shadow-md mb-3"
                            style="width:56px;height:56px;">
                            <span class="d-inline-flex align-items-center justify-content-center w-100 h-100 bg-white h4 my-0 lh-1 fw-semibold rounded-circle">
                                <span>{{ $loop->iteration }}</span>
                            </span>
                        </div>
                        <h3 class="h5 mb-2 fw-bold">{{ $step['title'] }}</h3>
                        <p class="mb-0">{{ $step['content'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container my-5">
        <h2 class="h4 mb-4 text-center fw-bold">
            Who GymSelect is for
        </h2>
        <div class="row gy-4 text-center text-md-start">
            <div class="col-12 col-md-6">
                <div class="card-bg-1 h-100 px-4 py-4 rounded-4">
                    <div class="d-md-none mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="56" height="67" viewBox="0 0 70 70">
                            <path d="m64.897 54.278-15.54-15.543a24.35 24.35 0 0 0 2.575-10.917c0-13.509-10.99-24.5-24.5-24.5s-24.5 10.991-24.5 24.5 10.99 24.5 24.5 24.5c4.16 0 8.079-1.045 11.514-2.881l15.35 15.21c1.399 1.4 3.263 1.937 5.248 1.937h.038c1.991 0 3.866-.56 5.278-1.974 1.413-1.412 2.197-3.079 2.207-5.071a7.3 7.3 0 0 0-2.17-5.261m-16.982-1.529 4.914-4.914 1.587 1.586-4.906 4.906zM6.933 27.818c0-11.323 9.178-20.5 20.5-20.5s20.5 9.177 20.5 20.5-9.178 20.5-20.5 20.5-20.5-9.176-20.5-20.5m40.29 14.419 4.191 4.186-4.921 4.92-4.149-4.104a24.7 24.7 0 0 0 4.879-5.002m14.809 19.546c-.663.662-1.54.8-2.471.8h-.018c-.916 0-1.775-.132-2.42-.776l-6.192-6.099 4.899-4.888 6.238 6.237c.648.648 1.003 1.444.998 2.368-.003.93-.371 1.694-1.034 2.358"/>
                            <path d="M25.274 11.712q-.585 0-1.16.047a1 1 0 1 0 .164 1.994q.493-.04.996-.041a1 1 0 1 0 0-2M19.463 12.978a14 14 0 0 0-8.136 12.683 1 1 0 1 0 2 0 11.99 11.99 0 0 1 6.97-10.866 1 1 0 1 0-.834-1.817"/>
                        </svg>
                    </div>
                    <h3 class="h4 fw-bold">For users</h3>
                    <div class="d-md-none">
                        <p class="mb-3 fw-medium">
                            Find trusted local services, compare reviews, and discover new businesses with confidence.
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <ul class="mb-4 ps-3 fw-medium">
                            <li>Find trusted services near you</li>
                            <li>Compare real reviews across platforms</li>
                            <li>Access exclusive member perks</li>
                            <li>Discover new businesses confidently</li>
                        </ul>
                    </div>
                    <a href="" class="btn btn-gradient w-100 link-dark px-5 fw-medium shadow-sm rounded-pill">
                        <span class="d-inline-block px-2">Explore GymSelect</span>
                        <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                            <x-icons.rocket />
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card-bg-2 h-100 px-4 py-4 rounded-4">
                    <div class="d-md-none mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="56" height="56" viewBox="0 0 70 70">
                            <path d="M65.395 6.077a2 2 0 0 0-1.612-1.612c-.206-.038-5.126-.914-11.318-.914-9.855 0-16.997 2.144-21.225 6.373l-.537.536c-2.187 2.183-4.851 4.846-7.267 7.703-2.254-.093-10.986-.071-14.767 5.473-3.872 5.678-4.919 12.259-4.961 12.536a2 2 0 0 0 1.739 2.291l12.613 1.505c.827 2.252 1.948 4.312 3.194 5.932l-3.074 3.073a2 2 0 1 0 2.828 2.828l3.09-3.09c1.711 1.293 3.817 2.389 6.047 3.178l1.525 12.797a2 2 0 0 0 2.291 1.74c.277-.043 6.857-1.091 12.536-4.962 6.127-4.178 5.509-14.407 5.447-15.248 2.754-2.354 5.318-4.918 7.432-7.035l.56-.561c9.497-9.497 5.628-31.606 5.459-32.543m-3.724 2.111c.294 2.15.769 6.524.604 11.313-2.305-.896-5.909-3.773-9.127-7.392-1.656-1.862-2.734-3.401-3.347-4.494a57 57 0 0 1 2.663-.064c3.932 0 7.375.385 9.207.637M8.108 34.752c.563-2.172 1.727-5.725 3.865-8.862 1.677-2.459 5.383-3.379 8.334-3.653-1.765 2.594-3.086 5.237-3.482 7.747-.296 1.883-.222 3.867.114 5.821zm36.135 23.407c-3.138 2.139-6.691 3.303-8.862 3.865l-1.079-9.058c1.061.174 2.111.269 3.122.269.853 0 1.683-.063 2.467-.188 2.604-.413 5.356-1.834 8.047-3.708-.212 3.014-1.085 7.041-3.695 8.82m12.864-22.367-.563.563c-4.435 4.443-11.858 11.881-17.281 12.741-3.693.596-8.913-.889-12.302-3.248l10.154-10.154a2 2 0 1 0-2.828-2.828L24.114 43.039c-2.264-3.179-3.984-8.32-3.337-12.434.858-5.441 8.303-12.874 12.751-17.314l.539-.539c3.221-3.22 8.561-4.534 13.569-4.991.854 1.936 2.737 4.238 4.018 5.677 2.979 3.351 7.272 7.184 10.508 8.134-.403 5.348-1.721 10.886-5.055 14.22"/>
                            <path d="m33.243 16.334-.384.384c-3.601 3.595-9.042 9.027-9.777 13.688a1 1 0 1 0 1.974.313c.635-4.019 6.006-9.382 9.216-12.586l.385-.385a.999.999 0 1 0-1.414-1.414M24.477 55.425c-2.446 2.446-8.259 2.362-11.533 1.992-.371-3.275-.454-9.088 1.992-11.534a2 2 0 1 0-2.828-2.828c-4.841 4.84-3.112 15.308-2.899 16.485a2 2 0 0 0 1.612 1.612 33.4 33.4 0 0 0 5.588.473c3.636 0 8.163-.639 10.896-3.372a2 2 0 1 0-2.828-2.828M45.365 17.845c-3.859 0-7 3.141-7 7s3.14 7 7 7 7-3.141 7-7-3.14-7-7-7m0 12c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5"/>
                        </svg>
                    </div>
                    <h3 class="h4 fw-bold">For businesses</h3>
                    <div class="d-md-none">
                        <p class="mb-3 fw-medium">
                            Reach high-intent local customers, stand out with perks, and build trust through reviews.
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <ul class="mb-4 ps-3 fw-medium">
                            <li>Get discovered by local, high-intent customers</li>
                            <li>Showcase offerings clearly</li>
                            <li>Offer perks to stand out</li>
                            <li>Build trust with reviews</li>
                        </ul>
                    </div>
                    <a href="" class="btn btn-gradient w-100 link-dark px-5 fw-medium shadow-sm rounded-pill">
                        <span class="d-inline-block px-2">List Your Business</span>
                        <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                            <x-icons.rocket />
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-front-layout>