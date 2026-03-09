@extends('layouts.front')

@push('styles')
<link rel="stylesheet" href="/assets/css/location-boost-cities.css?v={{ config('app.version') }}" />
@endpush

@section('content')
<article class="container">
    <section class="my-4 text-center">
        <div class="px-3 py-4 rounded-3 bg-white shadow-md">
            <h1 class="h4 font-weight-bold">
                Confirm Your Location Boost
            </h1>
            <p class="mb-0">
                Dominate your local area or expand into new locations.
                Limited featured spots per area.
            </p>
        </div>
    </section>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="mb-3 px-3 py-3 rounded-3 bg-white shadow-md">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <div class="font-weight-semibold">
                        Selected Boost Locations
                    </div>
                    <div>
                        <a href="{{ route('location-boost-cities.index') }}">
                            Change
                        </a>
                    </div>
                </div>
                @foreach($items as $item)
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <div data-place-id="{{ $item->place_id }}" class="font-weight-semibold">
                            {{ $item->postcode }} &mdash;
                            {{ !empty($item->city) ? $item->city : $item->country }}
                        </div>
                        <div class="py-1">
                            &pound;{{ number_format($item->price, 2) }} / month
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between align-items-center">
                    <div class="font-weight-semibold">
                        Monthly Total
                    </div>
                    <div class="font-weight-semibold py-1">
                        &pound;{{ number_format($total, 2) }} / month
                    </div>
                </div>
            </div>
            <p class="text-center small text-secondary">
                Starts today. Cancel anytime
            </p>
        </div>
        <div class="col-12 col-md-6">
            <div class="mb-3">
                <div id="payment-element"></div>
            </div>
            <div class="d-none">
                <button id="btn-checkout" type="button" class="btn btn-info w-100 py-2 rounded-3 font-weight-semibold">
                    <span>Subscribe</span>
                </button>
                <div class="my-2">
                    <p class="mb-3 small text-center text-secondary">
                        By confirming your subscription, you allow GymSelect Limited to charge you for future payments in accordance with their terms.
                        You can always cancel your subscription.
                    </p>
                </div>
            </div>
        </div>
    </div>

</article>
@endsection

@push('scripts')
<script type="text/javascript">
    var RETURN_URL = '';
    var STRIPE_KEY = '{{ $stripeKey }}';
    var CLIENT_SECRET = '{{ $clientSecret }}';
</script>
<script src="https://js.stripe.com/v3/"></script>
<script defer src="/assets/js/location-boost-cities-checkout.js?v={{ config('app.version') }}"></script>
@endpush
