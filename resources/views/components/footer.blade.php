<footer class="mt-auto py-2 border-top border-2 border-info bg-black text-white">
    <div class="container py-4">
        <div class="row gy-3 text-center text-sm-start">
            <div class="col-12 col-sm-6 col-lg-3">
                <p class="mb-3 fw-semibold text-info">
                    Company
                </p>
                <ol class="mb-0 list-unstyled">
                    <li>
                        <a href="{{ route('about') }}" class="mb-1 d-inline-block text-decoration-none link-light">
                            About
                        </a>
                    </li>
                    <li>
                        <a href="" class="mb-1 d-inline-block text-decoration-none link-light">
                            Perks
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="mb-1 d-inline-block text-decoration-none link-light">
                            Contact
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <p class="mb-3 fw-semibold text-info">
                    Explore
                </p>
                <ol class="mb-0 list-unstyled">
                    <li>
                        <a href="" class="mb-1 d-inline-block text-decoration-none link-light">
                            Search
                        </a>
                    </li>
                    <li>
                        <a href="" class="mb-1 d-inline-block text-decoration-none link-light">
                            Browse by region
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <p class="mb-3 fw-semibold text-info">
                    For Businesses
                </p>
                <ol class="mb-0 list-unstyled">
                    <li>
                        <a href="" class="mb-1 d-inline-block text-decoration-none link-light">
                            List Your Business
                        </a>
                    </li>
                    <li>
                        <a href="" class="mb-1 d-inline-block text-decoration-none link-light">
                            Business Network
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <p class="mb-3 fw-semibold text-info">
                    Partners
                </p>
                <ol class="mb-0 list-unstyled">
                    <li>
                        <a href="" class="mb-1 d-inline-block text-decoration-none link-light">
                            Become a Partner
                        </a>
                    </li>
                </ol>
                <div class="mt-4 mt-sm-0 d-inline-flex d-lg-none gap-2 align-items-center">
                    <a href="{{ config('app.social.links.instagram') }}" title="Instagram"
                        target="_blank" rel="noopener noreferrer nofollow" class="text-decoration-none link-light">
                        <x-icons.instagram />
                    </a>
                    <a href="{{ config('app.social.links.linkedin') }}" title="Linkedin"
                        target="_blank" rel="noopener noreferrer nofollow" class="text-decoration-none link-light">
                        <x-icons.linkedin-in />
                    </a>
                    <a href="{{ config('app.social.links.twitter') }}" title="Twitter X"
                        target="_blank" rel="noopener noreferrer nofollow" class="text-decoration-none link-light">
                        <x-icons.x-twitter />
                    </a>
                </div>
            </div>
        </div>
        <div class="my-3 border-top border-2 border-light opacity-25"></div>
        <div class="position-relative">
            <div class="text-center small d-md-flex gap-2 justify-content-center">
                <p class="mb-0">
                    &copy; {{ date('Y') }} GymSelect. All Rights Reserved.
                </p>
                <p class="mb-0">
                    <a href="/page/terms-conditions" class="text-decoration-none link-light">Terms</a>
                    |
                    <a href="/page/privacy-policy" class="text-decoration-none link-light">Privacy</a>
                </p>
            </div>
            <div class="position-absolute end-0 top-0 d-none d-lg-inline-flex gap-2 align-items-center">
                <a href="{{ config('app.social.links.instagram') }}" title="Instagram"
                    target="_blank" rel="noopener noreferrer nofollow" class="text-decoration-none link-light">
                    <x-icons.instagram />
                </a>
                <a href="{{ config('app.social.links.linkedin') }}" title="Linkedin"
                    target="_blank" rel="noopener noreferrer nofollow" class="text-decoration-none link-light">
                    <x-icons.linkedin-in />
                </a>
                <a href="{{ config('app.social.links.twitter') }}" title="Twitter X"
                    target="_blank" rel="noopener noreferrer nofollow" class="text-decoration-none link-light">
                    <x-icons.x-twitter />
                </a>
            </div>
        </div>
    </div>
</footer>