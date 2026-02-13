@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@section('content')
    @php
        $iconClass = ['visa' => 'visa','amex'=>'amex','discover'=>'discover','mastercard'=>'mastercard'];
    @endphp
    @include('sweet::alert')
    <section class="innerpage-cont body-cont list-deatils">
        <div class="container mob-hed-radius">
            <div class="contact-cont acc-deatils-cont">
                <div class="contact-mob-pad">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 mb-3">
                            <div class="signup-heading">
                                <h4>Plan</h4>
                                <p>View, track and manage your plan.</p>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 mb-3">
                            <div class="bg-white rounded shadow payment-custom-pad">
                                <div class="plan-payment">
                                    <h3>Payment Method</h3>
                                    <ul>
                                        @foreach($paymentMethods as $paymentMethod)
                                            @php
                                                $card = $paymentMethod->card;
                                                $isDefault = ($defaultPaymentMethod->id == $paymentMethod->id);
                                            @endphp
                                            <li>
                                                <div class="">
                                                    <span><i class="fab custom-card-icon fa-cc-{{ $iconClass[$card->brand] ?? 'visa' }}"></i></span>
                                                    <i class="fa fa-xs fa-circle"></i>
                                                    <i class="fa fa-xs fa-circle"></i>
                                                    <i class="fa fa-xs fa-circle"></i>
                                                    <i class="fa fa-xs fa-circle"></i>
                                                    {{ $card->last4 }}
                                                    @if($isDefault)
                                                        <span class="badge badge-default">Default</span>
                                                    @else
                                                        <a href="{{ route('account.defaultcard', $paymentMethod->id) }}">
                                                            <span class="badge badge-primary badge-hover">Make Default</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                <span class="ml-auto expire-cards">Expires {{ str_pad($card->exp_month, 2, 0, STR_PAD_LEFT) }}/{{ $card->exp_year }}
                                                    <div class="card-close">
                                                        @if(!$isDefault)
                                                            <a href="{{ route('account.removecard', $paymentMethod->id) }}">
                                                                <i class="fa fa-close"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="add-paymethod">
                                        <a href="javascript:void(0)">+ Add payment method</a>
                                        {{ html()->form('POST', route('account.savecard'))->open() }}
                                        <div id="add-new-card"></div>
                                        <button class="btn btn2 btn-block btn-save-card border-radius">Save Card</button>
                                        <input type="hidden" name="paymentMethod">
                                        {{ html()->form()->close() }}
                                    </div>
                                    <div class="card invoice-card">
                                        <div class="card-header">View billing history</div>
                                        <div class="card-body d-none"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
    </section>
     
@endsection

@push('footer_scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        const $invoiceCard = $('.invoice-card'),
            $cardForm = $('.add-paymethod form');

        let stripe = Stripe('{{env('STRIPE_KEY')}}'),
            stripeCard;

        function initStripe(stripe) {
            var elements = stripe.elements();
            var elementstyle = {
                iconStyle: 'solid',
                hidePostalCode: true,
                style: {
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
                }
            };


            stripeCard = elements.create('card', elementstyle);
            stripeCard.mount('#add-new-card');
        }

        async function stripeResponseHandler(result) {
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', stripeCard
            );

            if (error) {
                $cardForm.find(':submit').text('Save Card').removeAttr('disabled');
                swal("Error", error.message, "error");
            } else {
                stripeCard.clear();
                $cardForm.unbind("submit");
                $cardForm.find('[name="paymentMethod"]').val(paymentMethod.id);
                $cardForm.submit();
                return false;
            }
        }

        $(document).ready(function () {
            if (typeof stripe != 'undefined') {
                initStripe(stripe);
            }

            $invoiceCard.on('click', '.card-header', function () {
                $invoiceCard.find('.card-body').removeClass('d-none').html('<i class="fa fa-spin fa-spinner"></i>');
                $.get("{{ route('account.charges') }}", function (res) {
                    let invoices = '';
                    $.each(res, function (k, v) {
                        invoices += `<li>${v.date}<a target="_blank" href="${v.invoiceUrl}"><i class="fas fa-external-link-alt"></i></a></li>`;
                    });
                    $invoiceCard.find('.card-body').html(`<ul>${invoices}</ul>`);
                });
            });

            $cardForm.on('submit', function (e) {
                e.preventDefault();

                $cardForm.find(':submit').text('Please wait...').attr('disabled', 'disabled');
                stripe.createToken(stripeCard).then(stripeResponseHandler);
            });

            $(".add-paymethod a").on('click', function () {
                $cardForm.toggleClass("show");
            });
        });
    </script>
     
@endpush
