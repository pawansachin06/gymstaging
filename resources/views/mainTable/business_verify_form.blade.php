@extends('layouts.mainTable')
@section('content')
    @php
        $offerPrice = false;
        $price = $stripePrice = $setting->value['VERIFICATION_PRICE'] ?: 0;
        if(@$setting->value['VERIFICATION_OFFER_PRICE']){
            $offerPrice = $stripePrice = $setting->value['VERIFICATION_OFFER_PRICE'] ?: 0;
        }
    @endphp
    <section class="innerpage-cont body-cont verfiy-page-cont">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 mb-1">
                   
                    <div class="login-cont verify-deatils pb-2">
                        <h1 class="mt-2">Get Verified</h1>
                        @if($offerPrice)
                            <span>
                                <del>&pound; {{ $price }}</del>&nbsp; &pound;{{ $offerPrice }}
                            </span>
                        @else
                            <span>&pound;{{ $price }}</span>
                        @endif
                        <h6>One time payment</h6>
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
               
                    @if($listing->business_id == 1)
                        <p><u><b>To verify your account you must be:</b></u></p>
                        <p>Authentic. Your listing must represent a real
                            person, registered business or entity.</p>
                        <p><u><b>What happens once im verified?</b></u></p>
                        <p>Once verified, the ‘Verified’ badge will be
                            placed on your listing. This will also appear in
                            search results, helping you to stand out from
                            the crowd.</p>
                        <p><u><b>What to do</b></u></p>
                        <p>Please upload a picture of an official
                            document showing your business name and
                            address.</p>
                        <p>You can use:
                        <ul style="list-style-type:none;">
                            <li>- A business utility bill</li>
                        </ul>
                        </p>
                        <p>Your privacy is important to us. We’ll only use
                            this document to verify your business and will
                            never share or post it publicly.</p>
                    @else
                        <p><u><b>To verify your account you must be:</b></u></p>
                        <p>Authentic. Your listing must represent a real
                            person, registered business or entity.</p>
                        <p><u><b>What happens once im verified?</b></u></p>
                        <p>Once verified, the ‘Verified’ badge will be
                            placed on your listing. This will also appear in
                            search results, helping you to stand out from
                            the crowd.</p>
                        <p><u><b>What to do</b></u></p>
                        <p>Please upload a picture of an official
                            document showing either your name or your
                            companies name and address and proof of
                            qualifications.</p>
                        <p>You can use:
                        <ul style="list-style-type:none;">
                            <li>- Utility or phone bill</li>
                            <li>- Business utility or phone bill</li>
                            <li>- Qualification Certificates</li>
                        </ul>
                        </p>
                        <p>Your privacy is important to us. We’ll only use
                            this document to verify your business and will
                            never share or post it publicly.</p>
                    @endif
                </div>
            </div>

            <div class="row justify-content-md-center">
                <div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-1">
                    @if($listing->verifications()->pending()->count())
                        <div class="alert alert-success">
                            <ul>
                                <li>Verification submitted successfully. Please wait for admin approval</li>
                            </ul>
                        </div>
                    @else
                        <h5 class="upload-evidence">Please upload evidence:</h5>
                        {{ html()->form('POST', route('business.verification', $listing->id))->class('verify-form')->acceptsFiles()->open() }}
                        <div id="file-uploader"></div>

                        <div class="row my-3">
                        <!-- <div class="col-12 col-md-12 col-lg-5 col-xl-5 d-flex justify-content-center">
                            <div class="align-self-center text-center">
                                <img src="{{ asset('/gymselect/images/logo.png') }}" width="200">
                                <br>
                                <strong>
                                @if($offerPrice)
                            <span><del>&pound; {{ $price }}</del>&nbsp; &pound;{{ $offerPrice }}</span>
                                @else
                            <span>&pound;{{ $price }}</span>
                                @endif
                                <span> / once</span>
                                </strong>
                            </div>
                        </div> -->
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
                                @if($enableCoupon)
                                <div class="form-group" id="coupon-section">
                                    <div class="input-group mb-3">
                                        {{ html()->hidden('coupon_code') }}
                                        <input class="form-control" placeholder="Have a referral code?" id="c_code"/>
                                        <div class="input-group-append">
                                            <button class="btn btn2" type="button" id="apply-coupon">Apply</button>
                                        </div>
                                    </div>
                                    <div class="badge badge-danger" id="coupon-error-msg"></div>
                                    <div class="mt-3 badge badge-success" id="coupon-success-msg"></div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn2 verify-acc-btn border-radius">
                                Verify Account
                            </button>
                        </div>
                        {{ html()->form()->close() }}
                    @endif
                </div>
            </div>


        </div>
    </section>
@endsection
@push('footer_scripts')
    <link rel='stylesheet' href="//cdnjs.cloudflare.com/ajax/libs/paymentfont/1.1.2/css/paymentfont.min.css">
    <script src="//hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        let verifyForm = $('.verify-form'),
            verifyFiles = null,
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
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', stripeCard
            );

            if (error) {
                verifyForm.find(':submit').text('Verify Account').removeAttr('disabled');
                swal("Error", error.message, "error");
            } else {
                verifyFiles.startUpload();
                stripeCard.clear();
                stripeCardExpiry.clear();
                stripeCardCvc.clear();
                verifyForm.unbind("submit");
                verifyForm.find('[name="paymentMethod"]').val(paymentMethod.id);
                return false;
            }
        }

        $(document).ready(function () {
            if (typeof stripe != 'undefined') {
                initStripe(stripe);
            }

            verifyFiles = $("#file-uploader").uploadFile({
                url: "{{ route('business.verify.upload') }}",
                returnType: "json",
                autoSubmit: false,
                fileName: "file",
                showFileCounter: false,
                showFileSize: false,
                showAbort: false,
                showDelete: false,
                uploadStr: "Upload Files",
                dragDropStr: "",
                dragdropWidth: "auto",
                customProgressBar: function (obj, s) {
                    this.statusbar = $("<div class='ajax-file-upload-statusbar'></div>");
                    this.preview = $("<img class='ajax-file-upload-preview' />").width(s.previewWidth).height(s.previewHeight).appendTo(this.statusbar).hide();
                    this.filename = $("<div class='ajax-file-upload-filename'></div>").appendTo(this.statusbar);
                    this.progressDiv = $("<div class='ajax-file-upload-progress'>").appendTo(this.statusbar).hide();
                    this.progressbar = $("<div class='ajax-file-upload-bar'></div>").appendTo(this.progressDiv).hide();
                    this.abort = $("<div>" + s.abortStr + "</div>").appendTo(this.statusbar).hide();
                    this.cancel = $("<div class='ajax-file-upload-cancel'><i class='fa fa-close'></i></div>").appendTo(this.statusbar).hide();
                    this.done = $("<div>" + s.doneStr + "</div>").appendTo(this.statusbar).hide();
                    this.download = $("<div>" + s.downloadStr + "</div>").appendTo(this.statusbar).hide();
                    this.del = $("<div>" + s.deleteStr + "</div>").appendTo(this.statusbar).hide();

                    return this;
                },
                onSelect : function(files)
                {
                    fileCount += files.length;
                },
                onCancel : function(files)
                {
                    fileCount -= files.length;
                },
                afterUploadAll: function (obj) {
                    $.each(obj.responses, function(k, v){
                        $(`<input type="hidden" name="verification_file[]" value="${v}" />`).appendTo(verifyForm);
                    });
                    verifyForm.submit();
                }
            });
            // $('#file-uploader').imageUploader({
            //     label: "Upload File",
            //     imagesInputName: 'verification_file',
            //     preloadedInputName: 'old',
            //     maxFiles: 10
            // });
            // $('#verification-file').bind('change', function () {
            //     var filename = $("#verification-file").val();
            //     if (/^\s*$/.test(filename)) {
            //         $(".file-upload").removeClass('active');
            //         $("#noFile").text("No file chosen...");
            //     } else {
            //         $(".file-upload").addClass('active');
            //         $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            //     }
            // });

            verifyForm.on('submit', function (e) {
                e.preventDefault();
                if(fileCount == 0){
                    swal("Error" ,'Atleast one file sholud be uploaded', 'error');
                } else {
                    verifyForm.find(':submit').text('Please wait...').attr('disabled','disabled');
                    stripeResponseHandler();
                }
            });

            setTimeout(function () {
                $('#apply-coupon').on('click', function () {
                    var $this = $(this);
                    $.ajax({
                        async: false,
                        url: "{{ route('validate.verify.coupon') }}",
                        method: 'post',
                        data: {
                            'code': $('#c_code').val(),
                            'amount': {{$stripePrice}},
                        },
                        beforeSend: function () {
                            $('#coupon-success-msg, #coupon-error-msg').html('');
                        },
                        success: function (result) {
                            $('input[name="coupon_code"]').val(result.code);
                            $('#c_code').val('');
                            $('#coupon-success-msg').removeClass('d-none').html('Coupon Accepted - You have saved £' + result.offer_price);
                        },
                        error: function (xhr) {
                            $('input[name="coupon_code"], #c_code').val('');
                            var msg = $.parseJSON(xhr.responseText);
                            if (msg.errors) {
                                $.each(msg.errors, function (k, v) {
                                    $('#coupon-error-msg').append(v[0]);
                                });
                            }
                        }
                    });
                });
            }, 2000);
        });
    </script>
@endpush
