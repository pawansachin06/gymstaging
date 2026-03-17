<x-front-layout>
    <div class="position-relative">
        <div>
            <div class="clip-ellipse-bottom d-none d-md-block position-absolute top-0 left-0 right-0 bottom-0">
                <img src="https://images.unsplash.com/photo-1517964603305-11c0f6f66012?w=400&auto=format&fit=crop&q=60"
                    class="w-100 h-100 object-fit-cover" />
                <div class="position-absolute top-0 left-0 right-0 bottom-0 bg-black"></div>
            </div>
            <div class="d-md-none position-absolute top-0 left-0 right-0 bottom-0 bg-black"></div>
        </div>
        <div class="position-relative container pt-2 pb-4">
            <div class="d-flex flex-column align-items-center">
                <a href="/" class="mb-3 d-inline-flex flex-column text-decoration-none text-light text-center">
                    <img src="/assets/img/logo-banner-white.png" width="265" height="50" class="object-fit-contain" alt="GymSelect" />
                    <span>Search. Find. Connect.</span>
                </a>
                <div id="searchWidget" class="search-widget">
                    <div id="serviceInputBox" class="position-relative rounded-pill mb-3 z-2 bg-white">
                        <input id="serviceInput" autocomplete="off" spellcheck="false"
                            class="form-control position-relative mw-100 border-0 shadow-none fw-medium" placeholder="Search service or business" />
                        <div id="serviceSuggestions" class="suggestions position-absolute w-100 fw-medium shadow bg-white"></div>
                    </div>
                    <div id="locationInputBox" class="position-relative mb-3 d-none z-1">
                        <input id="locationInput" autocomplete="off" spellcheck="false"
                            class="form-control position-relative mw-100 border-0 shadow-none fw-medium pe-4" placeholder="Location or postcode" />
                            <div class="position-absolute top-0 end-0 pt-1 px-1">
                                <button id="detectLocation" title="My Location" class="btn px-1 py-1 lh-1 bg-transparent rounded-circle border-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 640 640">
                                        <path d="M320 48C337.7 48 352 62.3 352 80L352 98.3C450.1 112.3 527.7 189.9 541.7 288L560 288C577.7 288 592 302.3 592 320C592 337.7 577.7 352 560 352L541.7 352C527.7 450.1 450.1 527.7 352 541.7L352 560C352 577.7 337.7 592 320 592C302.3 592 288 577.7 288 560L288 541.7C189.9 527.7 112.3 450.1 98.3 352L80 352C62.3 352 48 337.7 48 320C48 302.3 62.3 288 80 288L98.3 288C112.3 189.9 189.9 112.3 288 98.3L288 80C288 62.3 302.3 48 320 48zM163.2 352C175.9 414.7 225.3 464.1 288 476.8L288 464C288 446.3 302.3 432 320 432C337.7 432 352 446.3 352 464L352 476.8C414.7 464.1 464.1 414.7 476.8 352L464 352C446.3 352 432 337.7 432 320C432 302.3 446.3 288 464 288L476.8 288C464.1 225.3 414.7 175.9 352 163.2L352 176C352 193.7 337.7 208 320 208C302.3 208 288 193.7 288 176L288 163.2C225.3 175.9 175.9 225.3 163.2 288L176 288C193.7 288 208 302.3 208 320C208 337.7 193.7 352 176 352L163.2 352zM320 272C346.5 272 368 293.5 368 320C368 346.5 346.5 368 320 368C293.5 368 272 346.5 272 320C272 293.5 293.5 272 320 272z" />
                                    </svg>
                                </button>
                            </div>
                        <div id="locationSuggestions" class="suggestions position-absolute w-100 fw-medium shadow bg-white"></div>
                    </div>
                    <button type="button" id="searchBtn" class="btn btn-gradient w-100 link-dark position-relative px-5 fw-medium rounded-pill d-none">
                        <span class="d-inline-block px-2">Search</span>
                        <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                            <x-icons.rocket />
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="container my-5">
        <h2 class="h4 mb-4 fw-bold text-center">
            Browse services in <span class="text-info">London</span>
        </h2>
        <div class="row gx-3 gy-3">
            @foreach($services as $service)
                <div class="col-4 col-lg-2">
                    <div class="h-100 px-1 py-3 text-center rounded-3 border border-light shadow-sm bg-white">
                        <img src="https://dummyimage.com/56" width="56" height="56" class="d-inline-block mb-3" />
                        <p class="mb-0 lh-sm fw-semibold">
                            {{ $service['name'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container my-5">
        <div class="d-flex flex-column flex-lg-row px-3 py-3 gap-2 d-lg-row align-items-center justify-content-center text-center border border-light rounded-3 shadow-sm">
            <div class="d-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="42" height="42" viewBox="0 0 70 70">
                    <path d="m64.897 54.278-15.54-15.543a24.35 24.35 0 0 0 2.575-10.917c0-13.509-10.99-24.5-24.5-24.5s-24.5 10.991-24.5 24.5 10.99 24.5 24.5 24.5c4.16 0 8.079-1.045 11.514-2.881l15.35 15.21c1.399 1.4 3.263 1.937 5.248 1.937h.038c1.991 0 3.866-.56 5.278-1.974 1.413-1.412 2.197-3.079 2.207-5.071a7.3 7.3 0 0 0-2.17-5.261m-16.982-1.529 4.914-4.914 1.587 1.586-4.906 4.906zM6.933 27.818c0-11.323 9.178-20.5 20.5-20.5s20.5 9.177 20.5 20.5-9.178 20.5-20.5 20.5-20.5-9.176-20.5-20.5m40.29 14.419 4.191 4.186-4.921 4.92-4.149-4.104a24.7 24.7 0 0 0 4.879-5.002m14.809 19.546c-.663.662-1.54.8-2.471.8h-.018c-.916 0-1.775-.132-2.42-.776l-6.192-6.099 4.899-4.888 6.238 6.237c.648.648 1.003 1.444.998 2.368-.003.93-.371 1.694-1.034 2.358"/>
                    <path d="M25.274 11.712q-.585 0-1.16.047a1 1 0 1 0 .164 1.994q.493-.04.996-.041a1 1 0 1 0 0-2M19.463 12.978a14 14 0 0 0-8.136 12.683 1 1 0 1 0 2 0 11.99 11.99 0 0 1 6.97-10.866 1 1 0 1 0-.834-1.817"/>
                </svg>
            </div>
            <h3 class="h5 fw-bold mb-0">Unlock Perks (free)</h3>
            <p class="mb-0 fw-medium">Access exclusive discounts and offers.</p>
            <div class="ms-lg-auto">
                <a href="/login?t=Personal" class="btn btn-gradient w-100 link-dark position-relative px-5 fw-medium rounded-pill">
                    <span class="d-inline-block px-0">Create Free Account</span>
                    <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                        <x-icons.rocket />
                    </span>
                </a>
            </div>
        </div>
    </section>

    <section class="container my-5">
        <div class="d-flex flex-column flex-lg-row px-3 py-3 gap-2 d-lg-row align-items-center justify-content-center text-center border border-light rounded-3 shadow-sm">
            <div class="d-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="42" height="42" viewBox="0 0 70 70">
                    <path d="M65.395 6.077a2 2 0 0 0-1.612-1.612c-.206-.038-5.126-.914-11.318-.914-9.855 0-16.997 2.144-21.225 6.373l-.537.536c-2.187 2.183-4.851 4.846-7.267 7.703-2.254-.093-10.986-.071-14.767 5.473-3.872 5.678-4.919 12.259-4.961 12.536a2 2 0 0 0 1.739 2.291l12.613 1.505c.827 2.252 1.948 4.312 3.194 5.932l-3.074 3.073a2 2 0 1 0 2.828 2.828l3.09-3.09c1.711 1.293 3.817 2.389 6.047 3.178l1.525 12.797a2 2 0 0 0 2.291 1.74c.277-.043 6.857-1.091 12.536-4.962 6.127-4.178 5.509-14.407 5.447-15.248 2.754-2.354 5.318-4.918 7.432-7.035l.56-.561c9.497-9.497 5.628-31.606 5.459-32.543m-3.724 2.111c.294 2.15.769 6.524.604 11.313-2.305-.896-5.909-3.773-9.127-7.392-1.656-1.862-2.734-3.401-3.347-4.494a57 57 0 0 1 2.663-.064c3.932 0 7.375.385 9.207.637M8.108 34.752c.563-2.172 1.727-5.725 3.865-8.862 1.677-2.459 5.383-3.379 8.334-3.653-1.765 2.594-3.086 5.237-3.482 7.747-.296 1.883-.222 3.867.114 5.821zm36.135 23.407c-3.138 2.139-6.691 3.303-8.862 3.865l-1.079-9.058c1.061.174 2.111.269 3.122.269.853 0 1.683-.063 2.467-.188 2.604-.413 5.356-1.834 8.047-3.708-.212 3.014-1.085 7.041-3.695 8.82m12.864-22.367-.563.563c-4.435 4.443-11.858 11.881-17.281 12.741-3.693.596-8.913-.889-12.302-3.248l10.154-10.154a2 2 0 1 0-2.828-2.828L24.114 43.039c-2.264-3.179-3.984-8.32-3.337-12.434.858-5.441 8.303-12.874 12.751-17.314l.539-.539c3.221-3.22 8.561-4.534 13.569-4.991.854 1.936 2.737 4.238 4.018 5.677 2.979 3.351 7.272 7.184 10.508 8.134-.403 5.348-1.721 10.886-5.055 14.22"/>
                    <path d="m33.243 16.334-.384.384c-3.601 3.595-9.042 9.027-9.777 13.688a1 1 0 1 0 1.974.313c.635-4.019 6.006-9.382 9.216-12.586l.385-.385a.999.999 0 1 0-1.414-1.414M24.477 55.425c-2.446 2.446-8.259 2.362-11.533 1.992-.371-3.275-.454-9.088 1.992-11.534a2 2 0 1 0-2.828-2.828c-4.841 4.84-3.112 15.308-2.899 16.485a2 2 0 0 0 1.612 1.612 33.4 33.4 0 0 0 5.588.473c3.636 0 8.163-.639 10.896-3.372a2 2 0 1 0-2.828-2.828M45.365 17.845c-3.859 0-7 3.141-7 7s3.14 7 7 7 7-3.141 7-7-3.14-7-7-7m0 12c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5"/>
                </svg>
            </div>
            <h3 class="h5 fw-bold mb-0">Get listed on GymSelect</h3>
            <p class="mb-0 fw-medium">Show up in search & attract new clients.</p>
            <div class="ms-lg-auto">
                <a href="/join" class="btn btn-gradient w-100 link-dark position-relative px-5 fw-medium rounded-pill">
                    <span class="d-inline-block px-2">List your business</span>
                    <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                        <x-icons.rocket />
                    </span>
                </a>
            </div>
        </div>
    </section>

</x-front-layout>