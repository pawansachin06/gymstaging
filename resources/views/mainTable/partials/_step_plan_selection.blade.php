<div class="row plan-selection-toggle">
    @php
        $m_plan = $plans->where('frequency', 'M')->first();
        $y_plan = $plans->where('frequency', 'Y')->first();
        $m_plan_amt = $m_plan->displayPrice ?? 0;
        $y_plan_amt = $y_plan->displayPrice ?? 0;
        $m_plan_freetrial = $m_plan->free_trial ?? 0;
        $y_plan_freetrial = $y_plan->free_trial ?? 0;
        $m_plan_offer_price = $m_plan->displayOfferPrice ?? 0;
        $y_plan_offer_price = $y_plan->displayOfferPrice ?? 0;
    @endphp
    <div class="col-12 col-md-12 col-lg-6 col-xl-6 order-lg-1">
        <div class="best-plan">Best Value</div>
     <div class="card card-lists membership-options-cont annual-plan">
            <div class="card-header text-center rounded-top">
                <h3>Annual Plan</h3>
                @if($y_plan_freetrial)
                    <!-- <h4>{{$y_plan_freetrial}} Day Free Trial</h4> -->
                @endif
                @if($y_plan_offer_price && $y_plan_offer_price != '0.00')
                    <span class="offer-price"><del>&pound;{{ round($y_plan_amt / 12) }}</del> &pound;{{$y_plan_offer_price}}</span><br/>
                @else
                    <span class="offer-price">&pound;{{ round($y_plan_amt / 12) }}</span>
                @endif
                <span class="plan-month">Per Month (Paid Annually)</span>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="radio-toolbar mt-0 custom-bar">
                        {{-- html()->radio('frequency', 'yearly', true, ['id' => 'frequency-y', 'class' => "btn btn-dark mx-auto rounded", 'data-amount' => $y_plan_amt, 'data-trial-days' => $y_plan_freetrial, 'data-period' => 'yearly', 'data-offer' => $y_plan_offer_price]) --}}
                        {{ html()->radio('frequency', true, 'yearly')
                            ->id('frequency-y')
                            ->class('btn btn-dark mx-auto rounded')
                            ->attributes([
                                'data-amount'     => $y_plan_amt,
                                'data-trial-days' => $y_plan_freetrial,
                                'data-period'     => 'yearly',
                                'data-offer'      => $y_plan_offer_price
                            ]) }}
                        <label for="frequency-y"></label>
                    </div>
                    <!-- <p class="require-text">*Credit card required upon signup to avoid service interruption</p> -->
                </li>
            </ul>
        </div>
        <div class="separator my-3 border-2">OR</div>
        <div class="card card-lists membership-options-cont">
            <div class="card-header text-center rounded-top">
                <h3>Monthly Plan</h3>
                @if($m_plan_freetrial)
                    <!-- <h4>{{$m_plan_freetrial}} Day Free Trial</h4> -->
                @endif
                @if($m_plan_offer_price && $m_plan_offer_price != '0.00')
                    <span class="offer-price"><del>&pound;{{$m_plan_amt}}</del> &pound;{{$m_plan_offer_price }}</span><br/>
                @else
                    <span class="offer-price">&pound;{{$m_plan_amt}}</span>
                @endif
                <span class="plan-month">Per Month</span>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class=" radio-toolbar mt-0 custom-bar">
                        {{-- html()->radio('frequency', 'monthly', false, ['id' => 'frequency-m', 'class' => "btn btn-dark mx-auto rounded", 'data-amount' => $m_plan_amt, 'data-trial-days' => $m_plan_freetrial, 'data-period' => 'monthly', 'data-offer' => $m_plan_offer_price]) --}}
                        {{ html()->radio('frequency', false, 'monthly')
                            ->id('frequency-m')
                            ->class('btn btn-dark mx-auto rounded')
                            ->attributes([
                                'data-amount'     => $m_plan_amt,
                                'data-trial-days' => $m_plan_freetrial,
                                'data-period'     => 'monthly',
                                'data-offer'      => $m_plan_offer_price
                            ]) }}
                        <label for="frequency-m"></label>
                    </div>
                    <!-- <p class="require-text">*Credit card required upon signup to avoid service interruption</p> -->
                </li>
            </ul>
        </div>
        <button type="button" class="mt-3 btn btn2 btn-block btn-plan-selection mob-none">Join</button>
    </div>
    <div class="col-12 col-md-12 col-lg-6 col-xl-6 gym-benefits">
        <div class="card card-lists">
            <div class="card-header rounded-top">
            Why join GymSelect?
            </div>
            <ul class="list-group list-group-flush listing-options1">
                @if($type == 'gym')
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get New Members</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get New Leads</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Improve SEO of Your Website</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get Found on Google</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get found on GymSelect</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase Logo</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Include Links to Your Website</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Include Links to Your Social Media</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide Contact Information</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase Facility Features</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide Facility Description</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase images of your facility</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide opening hours</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide membership options</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase Team Members</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase Timetable</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide Map Preview of Location</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase Member Reviews</li>
                @else
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get new clients</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get new leads</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Improve SEO of your website</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get you found on Google</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Get you found on GymSelect</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase your logo</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Include links to your website</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Include links to your social media</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide contact Information</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase your services</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Introduce yourself & your services</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase images of your work</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase client results</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase qualifications</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Provide Map Preview of Location</li>
                    <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> Showcase Client Reviews</li>
                @endif
            </ul>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mob-trial">
        <button type="button" class="mt-3 btn btn2 btn-block btn-plan-selection">Join</button>
    </div>
</div>
<div class="row plan-selection-toggle" style="display: none;">
    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
        <div class="payment-left">
            <!-- <p><img src="{{ asset('/gymselect/images/logo.png') }}" alt=" "></p> -->
                <p><span class="text-capitalize plan_freq" data-freq>Annual</span> Plan </p>
                <button type="button" class="mt-3 btn btn-plan-selection btn-change-plan">
                    Change Plan
                </button>
                <p class="mt-3"><strong> &pound; <span data-price>0</span> </strong> <span data-freq-short> p/a</span></p>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-6 col-xl-6 payment-right">
        <h4>Pay with card</h4>
        <div class="form-group">
            <label for="stripe-email">Name on card</label>
            {{ html()->text('stripe[name]', old('stripe.name'))->class('form-control') }}
        </div>
        <div class="form-row mb-3">
            <label for="stripe-card" class="">Card Information</label>
            <div class="col-12 card-field">
                <div id="card-number"></div>
                <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
            </div>
            <div class="col-6 card-field" id="card-expiry"></div>
            <div class="col-6 card-field" id="card-cvc"></div>
        </div>
        <div class="form-row mb-3">
            <label for="stripe-card" class="">Address</label>
            <div class="custom-billing-address">
                <div class="col-12 country-name">
                    {{ html()->text('address_line_1', old('address_line_1y'))->class('form-control')->placeholder('Address line 1') }}
                </div>
                <div class="col-12 country-name">
                    {{ html()->text('address_line_2', old('address_line_1'))->class('form-control')->placeholder('Address line 2') }}
                </div>
                <div class="col-12 country-name">
                    {{ html()->text('city', old('city'))->class('form-control')->placeholder('Town or City') }}
                </div>
                <div class="col-12 country-zip">
                    {{ html()->text('postal_code', old('postal_code'))->class('form-control')->placeholder('Postal Code') }}
                </div>
            </div>
        </div>
        <div class="form-group" id="coupon-section">
            <label for="c_code">Coupon</label>
            <div class="input-group mb-3">
                {{ html()->hidden('coupon_code') }}
                <input class="form-control" placeholder="Coupon code" id="c_code"/>
                <div class="input-group-append">
                    <button class="btn btn2" type="button" id="apply-coupon">Apply</button>
                </div>
            </div>
            <div class="badge badge-danger" id="coupon-error-msg"></div>
        </div>
        <div class="mt-3 badge badge-success" id="coupon-success-msg"></div>
        <input type="hidden" name="paymentMethod">
        <button type="button" class="mt-3 btn btn2 btn-block join-now" onclick="$('#step-form').steps('finish');">Join</button>
    </div>
</div>
