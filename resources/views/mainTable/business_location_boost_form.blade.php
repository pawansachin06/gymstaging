@extends('layouts.mainTable')
@section('content')
@php
$offerPrice = false;
$price = $stripePrice = $setting->value['BOOST_PRICE'] ?: 0;
if(@$setting->value['BOOST_OFFER_PRICE']){
$offerPrice = $stripePrice = $setting->value['BOOST_OFFER_PRICE'] ?: 0;
}
@endphp
<style>
    .glass-borders {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .br-20 {
        border-radius: 20px;
    }
    .br-15 {
        border-radius: 8px;
    }
    .bg-black {
        background-color: #404042;
    }
    .loc-boost-card {
        margin-top: 30px;
        min-height: 130px;
    }
    .loc-boost-card button {
        border: #fff solid 1px;
        background-color: transparent;
        color: #fff; width: 40%;
        border-radius: 20px;
        padding: 2px;
        font-weight: ;
    }
    .loc-boost-card button.active {
        background-color: #17a2b8;
    }
    .loc-boost-card .price-txt {
        margin-bottom: 8px;
    }
    .loc-boost-card .promotion-txt {
        font-size: 12px;
        margin-top: 6px;
        margin-bottom: 8px;
    }
    .loc-boost-card h6 {
        margin-top: 10px;
    }
    @media only screen and (min-width: 750px) {
        .loc-boost-card.col-md-6 {
            max-width: 45%;
        }
    }
</style>
<section class="innerpage-cont body-cont verfiy-page-cont">
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-12 col-lg-8 col-xl-8 mb-1">
                <div class="login-cont verify-deatils pb-2">
                    <h1 class="mt-2 text-white">Location <span class="text-primary">Boost</span></h1>
                    <h6 class="text-white">Do you offer online services & want to show up in more than one location?</h6>
                </div>

            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-1 mt-4">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="glass-borders br-20" style="padding: 20px 60px 20px 60px;">
                    <div class="glass-borders br-20" style="padding: 20px;">
                        <p>With location boost you can show up in more search results across different parts of the country.</p>
                        <p>This means you will be seen by more people in more locations, increasing the traffic to your listing.</p>
                        <p>To get started, simply select the plan you would like and click "Boost Location".</p>
                    </div>
                    <div class="row mt-3 justify-content-between">
                        @foreach($subscriptionPlans as $plan)
                            <div class="col-md-6 col-sm-12 br-15 bg-black d-flex flex-column align-items-center ml-3 mr-3 loc-boost-card">
                                <h6 class="text-primary">{{ $plan->plan_name }}</h6>
                                <p class="text-white price-txt">£{{ $plan->offer_amount }} p/m</p>
                                <button data-plan_id="{{ $plan->stripe_plan_id }}" class="select-loc-plan {{ ($plan->is_bestseller == '1') ? 'active' : '' }}">{{ ($plan->is_bestseller == '1') ? 'Selected' : 'Select' }}</button>
                                @if(!empty($plan->description))
                                    <p class="text-primary promotion-txt">{{ $plan->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <button type="button" style="width:45%;" data-toggle="modal" data-target="#stripe_card_modal" class="btn btn2 btn-block border-radius">Boost Location</button>
                    </div>
                </div>

            </div>
        </div>
</section>

<div class="modal fade" id="stripe_card_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pay with card</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="location-boost-form" action="{{ route('business.dolocationboost') }}">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 payment-right">
                    <div class="form-row mb-3">
                        <label for="stripe-card" class="">Card Information</label>
                        <div class="col-12 card-field">
                            <div id="card-number"></div>
                            <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                        </div>
                        <div class="col-6 card-field" id="card-expiry"></div>
                        <div class="col-6 card-field" id="card-cvc"></div>
                    </div>
                    <div class="mt-3 badge badge-success" id="coupon-success-msg"></div>
                    <input type="hidden" name="paymentMethod">
                    <input type="hidden" value="" name="stripePlanId">
                    <button type="button" class="mt-3 btn btn2 btn-block join-now" onclick="$('#location-boost-form').submit();">Boost Location</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@push('footer_scripts')
<link rel='stylesheet' href="//cdnjs.cloudflare.com/ajax/libs/paymentfont/1.1.2/css/paymentfont.min.css">
<script src="//hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    let locationBoostForm = $('#location-boost-form'),
        fileCount = 0,
        stripe = Stripe('{{env('STRIPE_KEY')}}'),
        stripeCard,
        stripeCardExpiry,
        stripeCardCvc,
        cardBrandToPfClass = {
            'visa': 'pf-visa',
            'mastercard': 'pf-mastercard',
            'amex': 'pf-american-express',
            'discover': 'pf-discover',
            'diners': 'pf-diners',
            'jcb': 'pf-jcb',
            'unknown': 'pf-credit-card',
        };

    function setBrandIcon(brand) {
        var brandIconElement = $('#brand-icon');
        var pfClass = 'pf-credit-card';
        if (brand in cardBrandToPfClass) {
            pfClass = cardBrandToPfClass[brand];
        }
        brandIconElement.attr('class', 'pf').addClass(pfClass);
    }

    function initStripe(stripe) {
        var elements = stripe.elements();
        var elementstyle = {
            base: {
                color: '#00a4e2',
                lineHeight: '28px',
                fontSmoothing: 'antialiased',
                '::placeholder': {
                    color: '#999',
                },
            },
            invalid: {
                color: '#e5424d',
                ':focus': {
                    color: '#303238',
                },
            },
        };

        stripeCard = elements.create('cardNumber', {
            style: elementstyle
        });
        stripeCard.mount('#card-number');
        stripeCard.on('change', function(event) {
            if (event.brand) {
                setBrandIcon(event.brand);
            }
        });


        stripeCardExpiry = elements.create('cardExpiry', {
            style: elementstyle
        });
        stripeCardExpiry.mount('#card-expiry');

        stripeCardCvc = elements.create('cardCvc', {
            style: elementstyle
        });
        stripeCardCvc.mount('#card-cvc');
    }

    async function stripeResponseHandler() {
        const {
            paymentMethod,
            error
        } = await stripe.createPaymentMethod(
            'card', stripeCard
        );

        if (error) {
            boostForm.find(':submit').text('Boost').removeAttr('disabled');
            swal("Error", error.message, "error");
        } else {
            stripeCard.clear();
            stripeCardExpiry.clear();
            stripeCardCvc.clear();
            locationBoostForm.find('[name="paymentMethod"]').val(paymentMethod.id);
        }
    }

    $(document).ready(function() {

        $('.select-loc-plan').click(function(){
            let _this = $(this);
            $('.select-loc-plan').each(function(){
                $(this).html('Select');
                $(this).removeClass('active');
            });
            _this.html('Selected');
            _this.addClass('active');
        });

        if (typeof stripe != 'undefined') {
            initStripe(stripe);
        }

        locationBoostForm.on('submit', async function (e) {
            e.preventDefault();
            let planId = "";
            $('.select-loc-plan').each(function(){
                if($(this).hasClass('active')) {
                    planId = $(this).attr('data-plan_id');
                }
            });
            locationBoostForm.find('[name="stripePlanId"]').val(planId);
            if(planId == "") {
                swal("Error", 'Please choose a location boost subscription plan', "error");
                return false;
            }
            await stripeResponseHandler();
            $.ajax({
                url: locationBoostForm.attr('action'),
                method: 'POST',
                data: locationBoostForm.serialize(),
                beforeSend: function () {
                    locationBoostForm.find('.join-now').html('Loading...');
                    locationBoostForm.find('.join-now').attr('disabled', true);
                },
                success: function (res) {
                    if (res.message) {
                        swal("Success", res.message, 'success');
                    }
                    if (res.returnUrl) {
                        setTimeout(() => {
                            window.location.href = res.returnUrl;
                        }, 500);
                    }
                },
                complete: function () {
                    locationBoostForm.find('.join-now').html('Boost Location');
                    locationBoostForm.find('.join-now').attr('disabled', false);
                },
                error: function (res) {
                    swal("Error", res.responseJSON.message, "error");
                },
            });
            return false;
        });

    });
</script>
@endpush

