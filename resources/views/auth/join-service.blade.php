<x-front-layout>
    <section x-data="joinService">
        <div class="position-relative mb-4">
            <div class="d-none d-md-block position-absolute clip-ellipse-bottom top-0 left-0 right-0 bottom-0">
                <div class="position-absolute top-0 left-0 right-0 bottom-0" style="background:linear-gradient(90deg, #f4fbfb, #fef4fe);"></div>
            </div>
            <div class="container position-relative pt-4 pt-md-5 pb-md-5 text-center">
                <div class="d-none d-md-block">
                    <h1 class="h1 fw-bold">Create account</h1>
                    <p class="mb-4 fw-medium">
                        Create an account to publish listings, unlock perks, and get discovered.
                    </p>
                </div>
                <div class="d-md-none">
                    <h2 class="h1 fw-bold">Create account</h2>
                    <p class="mb-0 fw-medium">
                        Create an account to publish listings, unlock perks, and get discovered.
                    </p>
                </div>
            </div>
        </div>
        <div class="container my-4">
            <div class="mb-4 position-relative bg-dark rounded-pill">
                <span x-cloak x-bind:style="{width: stepWidth +'%'}" style="width:33.33%;transition:width 300ms ease-in-out;"
                    class="position-absolute bg-primary-gradient h-100 start-0 d-flex align-items-center justify-content-center rounded-pill border border-2 shadow"></span>
                <div class="position-relative d-flex align-items-center text-center">
                    <a href="" x-on:click.prevent="goToStep(1)"
                        class="d-inline-block py-2 fw-semibold text-decoration-none text-white" style="width:33.33%">
                        Step 1
                    </a>
                    <a href="" x-on:click.prevent="goToStep(2)"
                        class="d-inline-block py-2 fw-semibold text-decoration-none text-white" style="width:33.33%">
                        Step 2
                    </a>
                    <a href="" x-on:click.prevent="goToStep(3)"
                        class="d-inline-block py-2 fw-semibold text-decoration-none text-white" style="width:33.33%">
                        Step 3
                    </a>
                </div>
            </div>
            <!-- step 1 start -->
            <div class="px-4 py-4 rounded-3 border border-light bg-white shadow mb-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6 col-xl-5">
                        <form x-on:submit.prevent="handleRegister($el)" action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="mb-3 shadow rounded">
                                <input type="text" name="name" required placeholder="Name" class="form-control rounded" />
                            </div>
                            <div class="mb-3 shadow rounded">
                                <input type="email" name="email" required placeholder="Email" class="form-control rounded" />
                            </div>
                            <div class="mb-3 shadow rounded position-relative" x-data="{visible: false}">
                                <input x-bind:type="visible ? 'text' : 'password'" name="password" required placeholder="Password" class="form-control rounded" />
                                <div class="position-absolute d-flex align-items-center top-0 bottom-0 end-0">
                                    <button type="button" x-on:click="visible = !visible" class="btn btn-sm border-0">
                                        <x-icons.fa.eye x-show="visible" x-cloak />
                                        <x-icons.fa.eye-slash x-show="!visible" />
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 shadow rounded">
                                <input type="password" name="password_confirmation" required placeholder="Confirm Password" class="form-control rounded" />
                            </div>
                            <div class="mb-2 d-flex gap-2">
                                <div class="align-self-start rounded border border-2 border-gradient-primary position-relative z-1 lh-1">
                                    <input class="form-check-input my-0 border-0" name="terms" type="checkbox" required id="form-item-terms" />
                                </div>
                                <label class="form-check-label user-select-none small lh-sm" for="form-item-terms">
                                    I have read and agree to the <a href="/page/terms-conditions" target="_blank" rel="noopener noreferrer nofollow" class="fw-semibold link-dark">Terms & Conditions</a> and <a href="/page/privacy-policy" target="_blank" rel="noopener noreferrer nofollow" class="fw-semibold link-dark">Privacy Policy</a>. *
                                </label>
                            </div>
                            <div class="mb-3 d-flex gap-2">
                                <div class="align-self-start rounded border border-2 border-gradient-primary position-relative z-1 lh-1">
                                    <input class="form-check-input my-0 border-0" name="newsletter" type="checkbox" value="" id="form-item-newsletter" />
                                </div>
                                <label class="form-check-label user-select-none small lh-sm" for="form-item-newsletter">
                                    Receive exclusive GymSelect perks, partner discounts, and early access to new offers.
                                </label>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-dark bg-gradient w-100 position-relative">
                                    <span class="fw-semibold">Create Account</span>
                                    <span class="position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                                        <x-icons.rocket />
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- step 1 end -->
        </div>
    </section>
</x-front-layout>