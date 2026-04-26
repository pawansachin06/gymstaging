<x-front-layout>
    <section x-data="joinService">
        <div class="position-relative mb-4">
            <div class="d-none d-md-block position-absolute clip-ellipse-bottom top-0 left-0 right-0 bottom-0">
                <div class="position-absolute top-0 left-0 right-0 bottom-0" style="background:linear-gradient(90deg, #f4fbfb, #fef4fe);"></div>
            </div>
            <div class="container position-relative pt-4 pt-md-5 pb-md-5 text-center">
                <div class="d-none d-md-block">
                    <h1 class="h1 fw-bold">
                        <span x-show="step == 1">Create account</span>
                        <span x-show="step == 2" x-cloak>Select Plan</span>
                        <span x-show="step == 3" x-cloak>Select Plan</span>
                    </h1>
                    <p class="mb-4 fw-medium">
                        <span x-show="step == 1">
                            Create an account to publish listings, unlock perks, and get discovered.
                        </span>
                        <span x-show="step == 2" x-cloak>
                            Choose a plan to start appearing in search.
                        </span>
                        <span x-show="step == 3" x-cloak>
                            Choose a plan to start appearing in search.
                        </span>
                    </p>
                </div>
                <div class="d-md-none">
                    <h2 class="h1 fw-bold">
                        <span x-show="step == 1">Create account</span>
                        <span x-show="step == 2" x-cloak>Select Plan</span>
                        <span x-show="step == 3" x-cloak>Select Plan</span>
                    </h2>
                    <p class="mb-0 fw-medium">
                        <span x-show="step == 1">
                            Create an account to publish listings, unlock perks, and get discovered.
                        </span>
                        <span x-show="step == 2" x-cloak>
                            Choose a plan to start appearing in search.
                        </span>
                        <span x-show="step == 3" x-cloak>
                            Choose a plan to start appearing in search.
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="container my-4">
            <div class="mb-4 position-relative bg-dark rounded-pill">
                <span x-cloak x-bind:style="{width: stepWidth +'%'}" style="width:33.33%;transition:width 300ms ease-in-out;"
                    class="position-absolute bg-primary-gradient h-100 start-0 d-flex align-items-center justify-content-center rounded-pill border border-2 shadow"></span>
                <div class="position-relative d-flex align-items-center text-center">
                    <span class="d-inline-block py-2 fw-semibold text-decoration-none text-white" style="width:33.33%">
                        Step 1
                    </span>
                    <span class="d-inline-block py-2 fw-semibold text-decoration-none text-white" style="width:33.33%">
                        Step 2
                    </span>
                    <span class="d-inline-block py-2 fw-semibold text-decoration-none text-white" style="width:33.33%">
                        Step 3
                    </span>
                </div>
            </div>

            <!-- step 1 start -->
            <div x-show="step == 1" class="px-4 py-4 rounded-3 border border-light bg-white shadow mb-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6 col-xl-5">
                        <form x-on:submit.prevent="handleRegister()" action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="mb-3 shadow rounded">
                                <input type="text" x-model="name" required placeholder="Name" autofocus class="form-control rounded" />
                            </div>
                            <div class="mb-3 shadow rounded">
                                <input type="email" x-model="email" required placeholder="Email" x-bind:disabled="registering" class="form-control rounded" />
                            </div>
                            <div class="mb-3 shadow rounded position-relative" x-data="{visible: false}">
                                <input x-bind:type="visible ? 'text' : 'password'" x-model="password" required placeholder="Password" class="form-control rounded" />
                                <div class="position-absolute d-flex align-items-center top-0 bottom-0 end-0">
                                    <button type="button" x-on:click="visible = !visible" class="btn btn-sm border-0">
                                        <x-icons.fa.eye x-show="visible" x-cloak />
                                        <x-icons.fa.eye-slash x-show="!visible" />
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 shadow rounded">
                                <input type="password" x-model="passwordConfirmation" required placeholder="Confirm Password" class="form-control rounded" />
                            </div>
                            <div class="mb-2 d-flex gap-2">
                                <div class="align-self-start rounded border border-2 border-gradient-primary position-relative z-1 lh-1">
                                    <input class="form-check-input my-0 border-0" name="terms" type="checkbox" required id="form-item-terms" />
                                </div>
                                <label class="form-check-label user-select-none small lh-sm" for="form-item-terms">
                                    I have read and agree to the <a href="/page/terms-conditions" target="_blank" rel="noopener noreferrer nofollow" class="fw-semibold link-dark">Terms & Conditions</a> and <a href="/page/privacy-policy" target="_blank" rel="noopener noreferrer nofollow" class="fw-semibold link-dark">Privacy Policy</a>. *
                                </label>
                                <input type="hidden" name="ajax" value="1" />
                                <input type="hidden" name="action" value="register" />
                            </div>
                            <div class="mb-3 d-flex gap-2">
                                <div class="align-self-start rounded border border-2 border-gradient-primary position-relative z-1 lh-1">
                                    <input class="form-check-input my-0 border-0" x-model="newsletter" type="checkbox" value="1" id="form-item-newsletter" />
                                </div>
                                <label class="form-check-label user-select-none small lh-sm" for="form-item-newsletter">
                                    Receive exclusive GymSelect perks, partner discounts, and early access to new offers.
                                </label>
                            </div>
                            <div>
                                <button type="submit" x-bind:disabled="registering" class="btn btn-dark bg-gradient w-100 position-relative">
                                    <span class="fw-semibold" x-text="registering ? 'Please wait...' : 'Create Account'">Create Account</span>
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
            <!-- step 2 start -->
            <div x-show="step == 2" x-cloak class="mb-5">
                <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap align-items-center user-select-none">
                    <div class="position-relative px-1 py-1 flex-grow-1 flex-md-grow-0 rounded-pill shadow" style="min-width:350px;">
                        <div class="position-relative">
                            <span x-cloak x-bind:style="{transform: duration == 'monthly' ? 'translateX(0%)' : 'translateX(100%)'}"
                                style="transition:transform 100ms ease-in-out;"
                                class="position-absolute w-50 h-100 left-0 d-flex align-items-center justify-content-center rounded-pill bg-black bg-gradient"></span>
                            <div class="position-relative d-flex align-items-center text-center">
                                <button type="button" x-on:click.prevent="duration = 'monthly'"
                                    x-bind:class="[duration === 'monthly' ? 'text-white' : 'text-black']"
                                    class="d-inline-block w-50 px-1 py-1 border-0 bg-transparent">
                                    <span class="fw-semibold">Monthly</span>
                                </button>
                                <button type="button" x-on:click.prevent="duration = 'yearly'"
                                    x-bind:class="[duration === 'yearly' ? 'text-white' : 'text-black']"
                                    class="d-inline-block w-50 px-1 py-1 border-0 bg-transparent">
                                    <span class="fw-semibold">Yearly</span> | Save 25%
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative ms-auto ms-md-0" x-on:click.outside="isCurrenciesOpen = false">
                        <button type="button" x-on:click="isCurrenciesOpen = !isCurrenciesOpen"
                            style="min-width:100px"
                            class="px-2 py-1 border border-light fw-semibold rounded-pill shadow bg-white">
                            <span x-text="currencyCode"></span>
                            <span x-text=toCurrencySymbol(currencyCode)></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 640 640">
                                <path d="M300.3 440.8C312.9 451 331.4 450.3 343.1 438.6L471.1 310.6C480.3 301.4 483 287.7 478 275.7C473 263.7 461.4 256 448.5 256L192.5 256C179.6 256 167.9 263.8 162.9 275.8C157.9 287.8 160.7 301.5 169.9 310.6L297.9 438.6L300.3 440.8z"/>
                            </svg>
                        </button>
                        <div class="position-relative">
                            <div x-cloak x-show="isCurrenciesOpen" x-transition.origin.top.right
                                class="position-absolute my-1 rounded-3 z-1 shadow bg-white">
                                <div class="d-flex flex-column px-1 py-1 text-nowrap">
                                    <template x-for="currency in currencies" x-bind:key="currency.id">
                                        <button type="button" x-on:click="handleCurrency(currency)" class="px-2 py-1 fw-medium rounded-3 border-0"
                                            x-bind:class="[currencyCode == currency.code ? 'bg-info text-white' : 'bg-white text-black']">
                                            <span x-text="currency.code"></span>
                                            <span x-text="toCurrencySymbol(currency.code)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <template x-for="membership in memberships" x-bind:key="membership.id">
                        <div x-show="duration === membership.duration"
                            class="col-12 col-md-6 col-lg-4" x-bind:class="getMembershipOrderClasses(membership)">
                            <div x-bind:class="[membership.is_popular ? '' : 'opacity-0']"
                                class="position-relative z-n2 py-1 bg-primary-gradient rounded-top-3 text-center small text-white">
                                <span class="fw-medium" x-text="membership.overline ?? 'Most Popular'"></span>
                                <span class="position-absolute top-0 bottom-0 end-0 d-inline-flex align-items-center px-1">
                                    <x-icons.material.crown />
                                </span>
                            </div>
                            <div x-bind:class="[membership.is_popular ? 'border-gradient-primary' : 'border-light']"
                                class="px-4 py-4 rounded-3 border-2 bg-white shadow">
                                <p class="mb-1">
                                    <strong x-text="membership.name"></strong>
                                </p>
                                <p class="mb-3 fw-medium" x-text="membership.excerpt"></p>
                                <p class="h3 mb-2 fw-semibold">
                                    <span x-text="getPrice(membership)"></span>
                                </p>
                                <p class="mb-0 lh-sm fw-medium">
                                    Per <span x-text="membership.duration === 'monthly' ? 'month' : 'year'"></span>
                                </p>
                                <p class="mb-3 lh-sm fw-medium" x-bind:class="membership.duration === 'monthly' ? 'text-info' : ''">
                                    <span x-text="membership.underline"></span>
                                </p>
                                <button type="button" x-bind:disabled="membership.loading" x-on:click="handleMembership(membership)" class="mb-3 btn btn-dark bg-gradient rounded-pill w-100">
                                    <span class="fw-semibold" x-text="membership.loading ? 'Please wait...' : 'Join Now'">Join Now</span>
                                </button>
                                <p class="mb-2 fw-semibold">
                                    <span x-text="getMembershipFeaturesTitle(membership)"></span>
                                </p>
                                <template x-for="(feature, featureInx) in membership.features" x-bind:key="featureInx">
                                    <div class="mb-2 d-flex align-items-start gap-2">
                                        <div class="flex-shrink-0">
                                            <x-icons.fa.circle-check />
                                        </div>
                                        <div class="fw-medium">
                                            <span x-text="feature.title"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <!-- step 2 end -->
            <!-- step 3 start -->
            <div x-show="step == 3" x-cloak class="mb-5">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="d-flex flex-column h-100">
                            <div>
                                <p class="mb-2 text-opacity-50">
                                    Subscribe to GymSelect Subscription
                                </p>
                                <div class="mb-4 d-flex gap-2">
                                    <p class="mb-0 h1 fw-semibold lh-1 text-nowrap">
                                        <span x-show="refreshingCheckout">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span>
                                        <span x-show="!refreshingCheckout" x-text="toPrice(pricing.subtotal, currencyCode)"></span>
                                    </p>
                                    <p class="mb-0 lh-sm text-secondary">
                                        per<br />
                                        <span x-text="duration === 'monthly' ? 'month' : 'year'"></span>
                                    </p>
                                </div>
                                <div class="mb-3 pb-3 d-flex justify-content-between border-bottom">
                                    <div>
                                        <p class="mb-0 fw-medium">GymSelect Subscription</p>
                                        <small class="text-secondary">
                                            Billed <span x-text="duration"></span>
                                        </small>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">
                                            <span x-text="toPrice(pricing.subtotal, currencyCode)"></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pb-2 d-flex justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium">Subtotal</p>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">
                                            <span x-text="toPrice(pricing.subtotal, currencyCode)"></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium text-info">
                                            <a data-bs-toggle="collapse" href="#collapseCouponCode" role="button" aria-expanded="false" aria-controls="collapseCouponCode">
                                                Add promotion code
                                            </a>
                                        </p>
                                        <div class="collapse" id="collapseCouponCode">
                                            <div class="input-group my-2">
                                                <input type="text" x-model="couponCode" placeholder="coupon code" class="form-control text-uppercase" />
                                                <button x-on:click="removeCoupon()" x-show="couponCode.length > 0" class="btn btn-outline-secondary" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                                    </svg>
                                                </button>
                                                <button x-on:click="refreshCheckout()" x-on:disabled="refreshingCheckout" class="btn btn-outline-secondary" type="button">
                                                    <span x-text="refreshingCheckout ? 'Checking..' : 'Apply'">Apply</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="pricing.discount > 0">
                                        <p class="mb-0 fw-semibold">
                                            <span x-text="toPrice(pricing.discount, currencyCode)"></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium">Total due today</p>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">
                                            <span x-text="toPrice(pricing.total, currencyCode)"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto mb-4">
                                <button type="button" x-on:click="goToStep(2)" class="btn btn-sm ps-2 pe-3 fw-medium btn-outline-dark rounded-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                    </svg>
                                    <span>Back to Plan Selection</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <div id="payment-element"></div>
                        </div>
                        <button type="button" x-bind:disabled="refreshingCheckout || isPaying" x-show="stripeReady" class="btn btn-info w-100 py-2 rounded-3 font-weight-semibold">
                            <span x-show="isPaying" class="spinner-border spinner-border-sm mx-1" role="status">
                                <span class="sr-only">Loading...</span>
                            </span>
                            <span x-text="isPaying ? 'Please wait...' : 'Subscribe'"></span>
                        </button>
                        <div x-show="stripeReady" class="my-2 small">
                            <p class="mb-0 small text-center text-secondary">
                                By confirming your subscription, you allow GymSelect Limited to charge you for future payments in accordance with their terms.
                                You can always cancel your subscription.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- step 3 end -->
        </div>
    </section>
    <script type="text/javascript">
        var STRIPE_KEY = '{{ $stripeKey }}';
    </script>
</x-front-layout>