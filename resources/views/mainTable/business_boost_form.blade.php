@extends('layouts.mainTable')
@section('content')
    @php
        $offerPrice = false;
        $price = $stripePrice = $setting->value['BOOST_PRICE'] ?: 0;
        if(@$setting->value['BOOST_OFFER_PRICE']){
            $offerPrice = $stripePrice = $setting->value['BOOST_OFFER_PRICE'] ?: 0;
        }
        $boost_count = 1;
        if( $boost_count == 0)
        {
    @endphp

    <section class="innerpage-cont body-cont verfiy-page-cont">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 mb-1">
                    <div class="login-cont verify-deatils pb-2">
                        <h1 class="mt-2 text-white">Review <span class="text-primary">Boost</span></h1>
                        @if($offerPrice)
                            <span>
                                <del class="text-primary">&pound; {{ $price }}</del>&nbsp; &pound;{{ $offerPrice }}
                            </span>
                        @else
                            <span>&pound;50</span>
                        @endif
                        <h6 class="text-primary">One time payment</h6>
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

                    <p><u><b> Do you already have existing reviews on Google or Facebook? </b></u></p>
                    <p> If you already have reviews on Facebook or Google, Review Boost is a great way to enhance and boost your listing. </p>
                    <p> It can sometimes be hard to get reviews, especially from people who have left them in the past. </p>
                    <p> With Review Boost, you don’t have to go back and ask people to leave another review for a second or third time. </p>
                    <p> Simply link your Google and Facebook account and you will be able to automatically show them on your listing. </p>
                    <p><u><b> How does it work? </b></u></p>
                    <p> Once you click ‘Boost’, you will be able to link your Google Listing and Facebook page straight away.</p>
                    <p> You will have the option to show ‘All’ reviews, or just your ‘5 Star’ and / or ‘4 Star Reviews’ only.</p>
                    <p> Note: </p>
                    <p> As Facebook now uses recommendations instead of a rating system, any recommendations will count as ‘5 Stars’ on GymSelect’.</p> </p>
                    <p><u><b> Why Review Boost? </b></u></p>
                    <p> Gain trust from potential customers by showing social proof in the form of great reviews!
                    <p> Save time for yourself and your customers by not having to contact them again, and by them not having to add another review! </p>
                    <p> Automatically boost your listing with great reviews you have already accumulated! </p>
                    <p> Turn your listing into a lead converting machine with great reviews and social proof! </p>
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-1">
                    {!! Form::open(['method' => 'POST', 'route' => ['business.boosted',$listing->id],'class'=>'verify-form']) !!}

                    <div class="row my-3">
                        <div class="col-12 col-md-12 col-lg-7 col-xl-7">
                            <div class="form-group">
                                <h4 class="pay-card">Pay with card</h4>
                                <div class="form-row mb-3 px-1">
                                    <div class="col-12 card-field">
                                        <div id="card-number"></div>
                                        <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                    </div>
                                    <div class="col-6 card-field" id="card-expiry"></div>
                                    <div class="col-6 card-field" id="card-cvc"></div>
                                </div>
                                <input type="hidden" name="paymentMethod">
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn2 verify-acc-btn border-radius">
                                    Boost
                                </button>


                            </div>

                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>

            </div>
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 mb-1">
                    <p style="color:grey">
                        Note: To protect our members, only accounts that are verified can utilise the Review Boost feature. If you are not yet Verified, you can still purchase Review Boost now at the discounted amount, then utilise it in the future once your account is
                        verified.
                    </p>
                </div>
            </div>
        </div>
    </section>
    @php
        }
    else
    {
        $listing_address=App\Models\ListingAddress::where('listing_id',$listing->id)->get();

        $google_reviews_count=App\Models\ListingReview::where('listing_id',$listing->id)->where('brand','G API')->count();

        $fb_reviews_count=App\Models\ListingReview::where('listing_id',$listing->id)->where('brand','F API')->count();
    @endphp

    <section class="innerpage-cont body-cont verfiy-page-cont">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="signup-heading">
                        <h4>Review <span style="color: #17a2b8">Boost</span></h4>
                        <p>Connect your Platforms.</p>
                    </div>
                </div>
            </div>

            @if(!$listing->verified)
                <p style="color:#DVAF37;text-align: center;font-size: 20px;font-weight: 500;margin-top: 50px;">Your account needs to be verified before you can use this feature.</p>
            @else
            <div class="form-group">
                <div class="row text-left">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12 review">
                        <div class="content">

                            <!-- Nav pills -->
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <img src="{{ asset('gymselect\images\google.png') }}">
                                    <span>Google</span>
                                    @if($google_reviews_count>0)
                                        <button class="nav-link" data-toggle="pill" href="#login" disabled>Done</a>
                                            @else
                                                <a class="nav-link" data-toggle="pill" href="#login">Add</a>
                                    @endif

                                </li>
                                <li class="nav-item">
                                    <img src="{{ asset('gymselect\images\facebook.png') }}">
                                    <span>Facebook (coming soon)</span>
                                    @if($fb_reviews_count>0)
                                        <button class="nav-link" data-toggle="pill" href="#regis" disabled>Done</a>
                                            @else
                                                <a class="nav-link" data-toggle="pill" href="#regis">Add</a>
                                    @endif
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content reviews">
                                <div id="login" class="container tab-pane">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <h3>Google</h3>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6>Enter your Google place ID</h6>
                                        </div>
                                        <div class="col-md-8">
                                            <form>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                        <input type="text" class="form-control mr-2" id="InputName" placeholder="Google place ID">
                                                        <button type="submit" id="load_google_reviews" class="btn btn-primary">Upload</button>
                                                    </div>
                                                    <small class="form-text text-muted"><a href="#" data-toggle="modal" data-target="#myModal"><u>Get your Google Place ID</u></a> </small>
                                                </div>
                                                
                                            </form>
                                        </div>
                                    </div>

                                    <hr>
                                    <div>
                                        <button type="submit" class="btn btn-cancel" id="hide_div">Remove</button>

                                        <button type="submit" class="btn btn-primary" id="connect_google" hidden>Connect</button>
                                    </div>
                                </div>


                                <div id="regis" class="container tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h3>Facebook (coming soon)</h3>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6>Enter your Page Username</h6>
                                            <p>Your username is located at the end of your Facebook page url: </p>
                                            <p> https://facebook.com/<font color="#00b5b8">username</font color="#00b5b8">/</p>

                                        </div>
                                        <div class="col-md-8">
                                            <form>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                        <input type="text" class="form-control mr-2" id="fb_username" placeholder="Username">
                                                        <button type="submit" id="load_fb_reviews" class="btn btn-primary">Load</button>

                                                    </div>
                                                    <small class="form-text text-muted"><a href
                                                        <p><u><a href="https://www.facebook.com/help/121237621291199" target="_blank">No username? Learn how</a></u></p></small>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <hr>

                                    <div>
                                        <button type="submit" id="hide_fb_div" class="btn btn-cancel">Remove</button>
                                        <button type="submit" class="btn btn-primary" id="connect_fb" hidden>Connect</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class='review_display text-center'>
                <div class='row'>
                    <div class='col-md-12'>
                        <h6 class='mt-4 mb-4' style="float:centre;">Connected Pages</h6>

                        <table class='review-table table table-striped'>
                            <thead>
                            <th scope='col'>Platform</th>
                            <th scope='col'>Rating</th>
                            <th scope='col'>Remove</th>
                            </thead>

                            <tbody>
                            @if($google_reviews_count>0)
                                <tr id='google_review_row'>

                                    <td class='table-data'>

                                        <img src="https://gymselectme.com/images/google.png" width="24">

                                    </td>
                                    <td><p>{{$listing->avg_google_rating}} ({{$google_reviews_count}}) </p></td>


                                    <td><a href='#' data-toggle='modal' data-target='#delgooglerev'><i class='fa fa-trash red'></i> </a></td>
                                </tr>
                                @endif
                                </tr>
                            </thead>
                            <tbody>

                            @if($fb_reviews_count>0)

                                <tr id='fb_review_row'>

                                    <td class='table-data'>


                                        <img src="{{ asset('gymselect\images\facebook.png') }}" width="24">

                                    </td>
                                    <td><p>{{$listing->avg_fb_rating}} ({{$fb_reviews_count}})</p></td>

                                    <td><a href='#' data-toggle='modal' data-target='#delfbrev'><i class='fa fa-trash red'></i> </a></td>

                                </tr>

                            @endif

                        </table>

                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-12'>
                        <h6 class='mt-4 mb-4'><font color="#00b5b8">Filter</font color="#00b5b8"></h6>
                        <p> Note: These filters don't apply to native GymSelect Reviews, only reviews from Facebook or Google.</p>
                    </div>
                </div>
                <div class='row' id='myDIV'>
                    <div class='col-md-4'>
                        <button type='submit' class='btn btn-filter all active'>All</button>
                    </div>
                    <div class='col-md-4'>
                        <button type='submit' class='btn btn-filter five'>5 Stars Only</button>
                    </div>
                    <div class='col-md-4'>
                        <button type='submit' class='btn btn-filter fourfive'>4 & 5 Stars</button>
                    </div>
                </div>
                <br><br>
                <div class='row'>
                    <div class='col-md-12'>
                        <button type='submit' id='save_filter' style='float:center;width:70%;' class='btn btn-success'>Save Filter</button>
                    </div>


                    <br><br><br><br><br>
                </div>
            </div>
            <div class='modal fade' id='delgooglerev' role='dialog'>
                <div class='modal-dialog'>

                    <!-- Modal content-->
                    <div class='modal-content'>
                        <div class='modal-body'>
                            <p class='text-center'> Are you sure?</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-danger' id='google_rev_del_confirm'>Confirm</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class='modal fade' id='delfbrev' role='dialog'>
                <div class='modal-dialog'>

                    <!-- Modal content-->
                    <div class='modal-content'>
                        <div class='modal-body'>
                            <p class='text-center'> Are you sure?</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-danger' id='fb_rev_del_confirm'>Confirm</button>
                        </div>
                    </div>

                </div>
            </div>
            @endif
        </div>
    </section>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-left"><strong>Step 1 - </strong>Visit link <a href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" target="_blank">here. </a></p>
                    <p class="text-left"><strong>Step 2 -</strong> Enter your business location. A location drop pin will display your Place ID.</p>
                    <p><img src="{{ asset('gymselect\images\pid_1.png') }}"></p>
                    <p class="text-left"><strong>Step 3 - </strong>Copy the Place ID: xxxxxxxxxxxxxxxxxxxx and you will need to <strong>paste</strong> it in the input field. </p>
                    <p><img src="{{ asset('gymselect\images\pid_2.png') }}"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="subs_close">Close</button>
                </div>
            </div>

        </div>
        @php
            }
        @endphp
        @endsection
        @push('footer_scripts')
            <link rel='stylesheet' href="//cdnjs.cloudflare.com/ajax/libs/paymentfont/1.1.2/css/paymentfont.min.css">
            <script src="//hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
            <script src="https://js.stripe.com/v3/"></script>
            <script type="text/javascript">
                let boostForm = $('.verify-form'),
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
                    stripeCard.on('change', function (event) {
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
                    const {paymentMethod, error} = await stripe.createPaymentMethod(
                        'card', stripeCard
                    );

                    if (error) {
                        boostForm.find(':submit').text('Boost').removeAttr('disabled');
                        swal("Error", error.message, "error");
                    } else {
                        stripeCard.clear();
                        stripeCardExpiry.clear();
                        stripeCardCvc.clear();
                        boostForm.unbind("submit");
                        boostForm.find('[name="paymentMethod"]').val(paymentMethod.id);
                        // return false;
                        boostForm.submit();
                    }
                }

                $(document).ready(function () {
                    if (typeof stripe != 'undefined') {
                        initStripe(stripe);
                    }

                    boostForm.on('submit', function (e) {
                        e.preventDefault();

                        boostForm.find(':submit').text('Please wait...').attr('disabled', 'disabled');
                        stripeResponseHandler();
                    });

                });
                document.addEventListener("DOMContentLoaded", function (event) {

                    setTimeout(() => {
                        $('#hide_div').on('click', function (event) {
                            event.preventDefault();
                            $('#nav nav-pills').removeClass("active");
                            $('#login').removeClass("active");
                        });

                        $('#hide_fb_div').on('click', function (event) {
                            event.preventDefault();
                            $('#nav nav-pills').removeClass("active");
                            $('#regis').removeClass("active");
                        });

                        $('#load_fb_reviews').on('click', function (event) {
                            event.preventDefault();
                            $("#load_fb_reviews").html("Loading").attr('disabled', 'disabled');

                            let fb_username = $('#fb_username').val();
                            $.ajax({
                                type: "POST",
                                url: "/load/fb_rev",
                                data: {fb_username: fb_username},
                                success: function (data, status) {
                                    if (data == "Loaded") {

                                        $('#fb_username').css("border", "1px solid green");
                                        $("#load_fb_reviews").html("Loaded");
                                        $("#load_fb_reviews").addClass('btn btn-success').removeClass('btn btn-primary');
                                        $('#connect_fb').removeAttr('hidden');
                                    } else {
                                        $('#fb_username').css("border", "1px solid red");
                                    }
                                }

                            });
                        });

                        $('#load_google_reviews').on('click', function (event) {
                            event.preventDefault();
                            $("#load_google_reviews").html("Loading").attr('disabled', 'disabled');
                            let place_id = $('#InputName').val();
                            $.ajax({
                                type: "POST",
                                url: "/load/google_rev",
                                data: {place_id: place_id},
                                success: function (data, status) {
                                    if (data == "Loaded") {

                                        $('#InputName').css("border", "1px solid green");
                                        $("#load_google_reviews").html("Loaded");
                                        $("#load_google_reviews").addClass('btn btn-success').removeClass('btn btn-primary');
                                        $('#connect_google').removeAttr('hidden');
                                    } else {
                                        $('#InputName').css("border", "2px solid red");
                                    }
                                }

                            });
                        });
                        $('#connect_fb').on('click', function (event) {
                            event.preventDefault();
                            $('#connect_fb').html("Connecting").attr('disabled', 'disabled');
                            $.ajax({
                                type: "POST",
                                url: "/connect/fb",
                                data: {},
                                success: function (data, status) {
                                    $('#connect_fb').html("Connected");
                                    $('#connect_fb').addClass('btn btn-success').removeClass('btn btn-primary');
                                    $('#hide_fb_div').hide();
                                    $('.review_display').html(data);

                                    $('.all').on('click', function (event) {
                                        event.preventDefault();
                                        $('#save_filter').html('Save Filter');
                                        $('.five').removeClass("active");
                                        $('.fourfive').removeClass("active");
                                        $('.all').addClass("active");
                                    });
                                    $('.five').on('click', function (event) {
                                        event.preventDefault();
                                        $('#save_filter').html('Save Filter');
                                        $('.all').removeClass("active");
                                        $('.fourfive').removeClass("active");
                                        $('.five').addClass("active");
                                    });
                                    $('.fourfive').on('click', function (event) {
                                        event.preventDefault();
                                        $('#save_filter').html('Save Filter');
                                        $('.all').removeClass("active");
                                        $('.five').removeClass("active");
                                        $('.fourfive').addClass("active");
                                    });
                                    $('#fb_rev_del_confirm').on('click', function (event) {
                                        event.preventDefault();
                                        $('#delfbrev').modal('hide');
                                        let brand = "F API";
                                        $.ajax({
                                            type: "POST",
                                            url: "/delete/reviews",
                                            data: {brand: brand},
                                            success: function (data, status) {
                                                if (data == "F API Brand Reviews Deleted Successfully") {
                                                    $('#fb_review_row').hide();
                                                    location.reload();
                                                }
                                            }
                                        });
                                    });
                                    $('#save_filter').on('click', function (event) {
                                        event.preventDefault();
                                        if ($('.all').hasClass("active")) {
                                            let filter_val = "All";
                                            $.ajax({
                                                type: "POST",
                                                url: "/save/filter",
                                                data: {filter_val: filter_val},
                                                success: function (data, status) {
                                                    $('#save_filter').html(data);
                                                }
                                            });
                                        } else if ($('.five').hasClass("active")) {
                                            let filter_val = "Five";
                                            $.ajax({
                                                type: "POST",
                                                url: "/save/filter",
                                                data: {filter_val: filter_val},
                                                success: function (data, status) {
                                                    $('#save_filter').html(data);
                                                }
                                            });
                                        } else if ($('.fourfive').hasClass("active")) {
                                            let filter_val = "Four&Five";
                                            $.ajax({
                                                type: "POST",
                                                url: "/save/filter",
                                                data: {filter_val: filter_val},
                                                success: function (data, status) {
                                                    $('#save_filter').html(data);
                                                }
                                            });
                                        }

                                    });
                                }
                            });
                        });


                        $('.all').on('click', function (event) {
                            event.preventDefault();
                            $('#save_filter').html('Save Filter');
                            $('.five').removeClass("active");
                            $('.fourfive').removeClass("active");
                            $('.all').addClass("active");
                        });
                        $('.five').on('click', function (event) {
                            event.preventDefault();
                            $('#save_filter').html('Save Filter');
                            $('.all').removeClass("active");
                            $('.fourfive').removeClass("active");
                            $('.five').addClass("active");
                        });
                        $('.fourfive').on('click', function (event) {
                            event.preventDefault();
                            $('#save_filter').html('Save Filter');
                            $('.all').removeClass("active");
                            $('.five').removeClass("active");
                            $('.fourfive').addClass("active");
                        });
                        $('#fb_rev_del_confirm').on('click', function (event) {
                            event.preventDefault();
                            $('#delfbrev').modal('hide');
                            let brand = "F API";
                            $.ajax({
                                type: "POST",
                                url: "/delete/reviews",
                                data: {brand: brand},
                                success: function (data, status) {
                                    if (data == "F API Brand Reviews Deleted Successfully") {
                                        $('#fb_review_row').hide();
                                        location.reload();
                                    }
                                }
                            });
                        });
                        $('#google_rev_del_confirm').on('click', function (event) {
                            event.preventDefault();
                            $('#delgooglerev').modal('hide');
                            let brand = "G API";
                            $.ajax({
                                type: "POST",
                                url: "/delete/reviews",
                                data: {brand: brand},
                                success: function (data, status) {
                                    if (data == "G API Brand Reviews Deleted Successfully") {
                                        $('#google_review_row').hide();
                                        location.reload();
                                    }
                                }
                            });
                        });
                        $('#save_filter').on('click', function (event) {
                            event.preventDefault();
                            if ($('.all').hasClass("active")) {
                                let filter_val = "All";
                                $.ajax({
                                    type: "POST",
                                    url: "/save/filter",
                                    data: {filter_val: filter_val},
                                    success: function (data, status) {
                                        $('#save_filter').html(data);
                                    }
                                });
                            } else if ($('.five').hasClass("active")) {
                                let filter_val = "Five";
                                $.ajax({
                                    type: "POST",
                                    url: "/save/filter",
                                    data: {filter_val: filter_val},
                                    success: function (data, status) {
                                        $('#save_filter').html(data);
                                    }
                                });
                            } else if ($('.fourfive').hasClass("active")) {
                                let filter_val = "Four&Five";
                                $.ajax({
                                    type: "POST",
                                    url: "/save/filter",
                                    data: {filter_val: filter_val},
                                    success: function (data, status) {
                                        $('#save_filter').html(data);
                                    }
                                });
                            }

                        });


                        $('#connect_google').on('click', function (event) {
                            event.preventDefault();
                            $('#connect_google').html("Connecting").attr('disabled', 'disabled');
                            $.ajax({
                                type: "POST",
                                url: "/connect/google",
                                data: {},
                                success: function (data, status) {
                                    $('#connect_google').html("Connected").attr('disabled', 'disabled');
                                    $('#connect_google').addClass('btn btn-success').removeClass('btn btn-primary');
                                    $('#hide_div').hide();
                                    $('.review_display').html(data);

                                    $('.all').on('click', function (event) {
                                        event.preventDefault();
                                        $('#save_filter').html('Save Filter');
                                        $('.five').removeClass("active");
                                        $('.fourfive').removeClass("active");
                                        $('.all').addClass("active");
                                    });
                                    $('.five').on('click', function (event) {
                                        event.preventDefault();
                                        $('#save_filter').html('Save Filter');
                                        $('.all').removeClass("active");
                                        $('.fourfive').removeClass("active");
                                        $('.five').addClass("active");
                                    });
                                    $('.fourfive').on('click', function (event) {
                                        event.preventDefault();
                                        $('#save_filter').html('Save Filter');
                                        $('.all').removeClass("active");
                                        $('.five').removeClass("active");
                                        $('.fourfive').addClass("active");
                                    });
                                    $('#google_rev_del_confirm').on('click', function (event) {
                                        event.preventDefault();
                                        $('#delgooglerev').modal('hide');
                                        let brand = "G API";
                                        $.ajax({
                                            type: "POST",
                                            url: "/delete/reviews",
                                            data: {brand: brand},
                                            success: function (data, status) {
                                                if (data == "G API Brand Reviews Deleted Successfully") {
                                                    $('#google_review_row').hide();
                                                    location.reload();
                                                }
                                            }
                                        });
                                    });
                                    $('#save_filter').on('click', function (event) {
                                        event.preventDefault();
                                        if ($('.all').hasClass("active")) {
                                            let filter_val = "All";
                                            $.ajax({
                                                type: "POST",
                                                url: "/save/filter",
                                                data: {filter_val: filter_val},
                                                success: function (data, status) {
                                                    $('#save_filter').html(data);
                                                }
                                            });
                                        } else if ($('.five').hasClass("active")) {
                                            let filter_val = "Five";
                                            $.ajax({
                                                type: "POST",
                                                url: "/save/filter",
                                                data: {filter_val: filter_val},
                                                success: function (data, status) {
                                                    $('#save_filter').html(data);
                                                }
                                            });
                                        } else if ($('.fourfive').hasClass("active")) {
                                            let filter_val = "Four&Five";
                                            $.ajax({
                                                type: "POST",
                                                url: "/save/filter",
                                                data: {filter_val: filter_val},
                                                success: function (data, status) {
                                                    $('#save_filter').html(data);
                                                }
                                            });
                                        }

                                    });
                                }
                            });
                        });


                    }, 1000);

                });

            </script>
    @endpush
