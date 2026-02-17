@extends('layouts.mainTable')
@push('header_scripts')
    <link href="{{asset('css/tabular-input.css')}}" rel="stylesheet">
@endpush
@php $dev = !empty($_GET['dev']); @endphp
@section('content')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto business-form editlist-cont">
                    @include('partials.heading',['title'=> $titles[1]['title'],'subtitle'=> $titles[1]['subtitle']])
                    {{ html()->form('POST', route(...$saveRoute))->id('step-form')->acceptsFiles()->class($editBiz ? 'edit-business hide-border' : '')->open() }}
                    <h3
                        data-title="{{ $titles[1]['title'] }}"
                        data-subtitle="{{ $titles[1]['subtitle'] }}">
                    </h3>
                    <fieldset class="pb-5">
                        @includeWhen(!$id, 'mainTable.partials._step_user_info')
                    </fieldset>
                    <h3
                        data-title="{{ $titles[2]['title'] }}"
                        data-subtitle="{{ $titles[2]['subtitle'] }}">
                    </h3>
                    <fieldset class="pb-5">
                        @includeWhen((!$id && $coupons->count()), 'mainTable.partials._step_coupon')
                        @includeWhen(!$id, 'mainTable.partials._step_plan_selection')
                    </fieldset>
                    <h3
                        data-title="{{ $titles[3]['title'] }}"
                        data-subtitle="{{ $titles[3]['subtitle'] }}">
                    </h3>
                    <fieldset class="pb-5">
                        @includeWhen($id, "mainTable.partials._step_{$type}_form")
                    </fieldset>

                {{ html()->hidden('mode', null)->id('mode') }}
                {{ html()->hidden('listing[timetable]', $listing->timetable ?? null)->id('timetableFile') }}
                {{ html()->form()->close() }}

                <!-- End rounded tabs -->
                </div>
            </div>
        </div>
    </section>
    <div id="mem-options-tmpl" class="d-none">

    </div>
@endsection
@push('footer_scripts')
    @include('partials.script-step-wizard')
    @include('partials.script-timepicker')
    @include('partials.script-niceselect')
    @include('partials.script-autocomplete')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.1/min/dropzone.min.js" integrity="sha512-OTNPkaN+JCQg2dj6Ht+yuHRHDwsq1WYsU6H0jDYHou/2ZayS2KXCfL28s/p11L0+GSppfPOqwbda47Q97pDP9Q==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.1/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous"/>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link rel='stylesheet' href="//cdnjs.cloudflare.com/ajax/libs/paymentfont/1.1.2/css/paymentfont.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/tabular-input.js') }}"></script>

    <script type="text/javascript">
        var stepForm = $("#step-form"),
            heading = $('.signup-heading'),
            loggedUserId = {{ $id ?? 0 }},
            isGym = {{ (int) (@$listing->business_id == 1) }},
            isCoach = {{ (int) (@$listing->business_id == 2) }},
            isPhysio = {{ (int) (@$listing->business_id == 3) }},
            membershipOptions = {!! json_encode($memberships) !!},
            qualificationOptions = {!! json_encode($qualifications) !!},
            profile_image = "{{ $listing->profile_image ?? null}}",
            cover_image = "{{ $listing->cover_image ?? null}}",
            media_images = {!! json_encode($media) !!},
            result_images = {!! json_encode($results) !!},
            storagePath = "{{asset('/storage/')}}",
            thumb_storagePath = "{{asset('/storage/thumb')}}",
            teamOptions = {!! json_encode($teams) !!},
            time_table = "{{ $listing->timetable ?? null}}",
            type = "{{ $type }}",
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

        const placeholders = {
            memOption: {
                1: {
                    name: 'Option Name e.g. Day Pass',
                    price: 'Price e.g.  7',
                    include: 'e.g. Full gym access',
                },
                2: {
                    name: 'Name e.g. Gold Plan',
                    price: 'Price e.g. £300 p/m',
                    include: 'e.g. 3 PT Sessions p/w',
                },
                3: {
                    name: 'Name e.g. Massage',
                    price: 'Price e.g. £30',
                    include: 'e.g. Consultation',
                }
            }
        };
        Dropzone.autoDiscover = false;

        $.views.helpers({
            ph_mem_option: placeholders.memOption[{{ (int) (@$listing->business_id) }}]
        });

        $.templates({
            membershipOption: '<div class="col-12 col-md-6  col-lg-6 col-xl-6 mt-4 pr-0 append-section" data-uid="[%:UUID%]"><div class="new-options-container"><div class="new-options-heading"> Options</div><div class="member-plan">' +
                '<input class="form-control" placeholder="[%:~ph_mem_option.name%]" name="membership_options[[%:UUID%]][name]" type="text" value="[%:NAME%]">' +
                '</div><div class="member-plan"><input class="form-control" placeholder="[%:~ph_mem_option.price%]" name="membership_options[[%:UUID%]][price]" type="text" value="[%:PRICE%]">' +
                '</div><div class="member-includes"><div class="btn btn2 btn-block include-heading">What does this include?</div><div class="member-includes-list"><ul>[%:optionIncludes%]</ul>' +
                '<button type="button" class="btn btn2 btn-block btn-includes"><i class="fas fa-plus" aria-hidden="true"></i></button></div>' +
                '</div><i class="fas fa-times close-section"></i></div></div></div>',
            optionIncludes: '<li class="append-section"><input class="form-control plan-includes" placeholder="[%:~ph_mem_option.include%]" name="membership_options[[%:UUID%]][includes][]" type="text" value="[%:INCLUDE%]"><i class="fas fa-times close-section" aria-hidden="true"></i></li>',
            teamMember: '<div class="col-12 col-md-6 col-lg-3 col-xl-3 append-section"><div class="team-profile">' +
                '<div class="wrapper gym-team-thumb"><div class="file-upload profilephoto" id="upload-holder">' +
                '<input id="file_path[%:KEY%]" name="team_edit[file_path][[%:KEY%]]" type="file">' +
                '<input type="hidden" name="team_edit[old_file_path][[%:KEY%]]" value="[%:FILE%]"></div>' +
                '</div><div class="form-group member-input"><input type="text" name="team_edit[name][[%:KEY%]]" value="[%:NAME%]" class="form-control" placeholder="Name"></div>' +
                '<div class="form-group member-top member-input"><input type="text" class="form-control"  value="[%:JOB%]"  name = "team_edit[job][[%:KEY%]]" placeholder="Job Title">' +
                '</div><div class="form-group member-top mar-o member-input">' +
                '<input type="text" class="form-control iconAutoComplete" value="[%:USERNAME%]" placeholder="@profile" data-url="[%:URL%]" autocomplete="off">' +
                '<input type="hidden" name="team_edit[user_id][[%:KEY%]]" value="[%:USERID%]">' +
                '</div></div><i class="fas fa-times close-section"></i></div>',
            mediaUpload: '<div class="media uploaded append-section"><img class="img-thumbnail" src="[%:FILEURL%]" title="[%:FILENAME%]"><input type="hidden" name="media_edit[]" value="[%:FILENAME%]"><i class="fas fa-times close-section" aria-hidden="true"></i></div>'
        });

        var fileTypes = {!! json_encode(\App\Http\Controllers\Traits\FileUploadTrait::$accepted_type) !!};

        function readURL(input) {
            if (input.files && input.files[0]) {
                var isSuccess = fileValidate(input.files[0], fileTypes);
                if (isSuccess) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#upload-holder').css({
                            'background-image': 'url(' + e.target.result + ')',
                            'background-size': 'cover',
                        }).hide().fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    swal("Wrong file format", "Please upload only png,jpg and gif files", "error");
                }
            }

        }

        function readURLTeamImage(e, that) {
            var files = e.target.files[0];

            var isSuccess = fileValidate(files, fileTypes);

            if (isSuccess) {
                var fileReader = new FileReader();
                fileReader.onload = function (e) {

                    that.parent('.file-upload').css({
                        'background-image': 'url(' + e.target.result + ')',
                        'background-size': 'cover',
                    }).hide().fadeIn(650);
                }
                that.next('.fa-user').hide();
                fileReader.readAsDataURL(files);
            } else {
                swal("Wrong file format", "Please upload only png,jpg and gif files", "error");
            }
        }


        function readURLCover(input) {
            if (input.files && input.files[0]) {
                var isSuccess = fileValidate(input.files[0], fileTypes);
                if (isSuccess) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#upload-holder-cover').css({
                            'background-image': 'url(' + e.target.result + ')',
                            'background-size': 'cover',
                        }).hide().fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    swal("Wrong file format", "Please upload only png,jpg and gif files", "error");
                }
            }
        }

        function readURLMedia(e) {
            var files = e.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];

                var isSuccess = fileValidate(f, fileTypes);
                if (isSuccess) {
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("<div class='media uploaded append-section'><img class='img-thumbnail' src='" + file.result + "' title='" + file.name + "'/>" +
                            "<i class='fas fa-times close-section'></i></div>").insertAfter("#upload-holder-media");
                    });
                    fileReader.readAsDataURL(f);
                } else {
                    swal("Wrong file format", "Please upload only png,jpg and gif files", "error");
                }
            }
        }


        function createTeamBlock() {
            $("<div class='col-12 col-md-6 col-lg-3 col-xl-3 append-section'><div class='team-profile'>"
                + "<div class='wrapper  gym-team-thumb'><div class='file-upload profilephoto' id='upload-holder'>"
                + "<input id='file_path' name='team[file_path][]' type='file'>"
                + "<i class='fas fa-4x fa-user' aria-hidden='true'></i></div>"
                + "</div><div class='form-group member-input'><input type='text' name='team[name][]' class='form-control' placeholder='Name'></div>"
                + "<div class='form-group member-top member-input'><input type='text' class='form-control' name='team[job][]' placeholder='Job Title'>"
                + "</div><div class='form-group member-top mar-o member-input'>"
                + "<input type='text' class='form-control iconAutoComplete' placeholder='@profile' data-url='{{ route('autosearch.listing',['icon','val'=>'user_id']) }}' autocomplete='off'>"
                + "<input type='hidden' name='team[user_id][]' />"
                + "</div></div><i class='fas fa-times close-section'></i></div>").insertAfter(".upload-team");

        }


        function readURLTimeTable(e) {
            var fileTypes = ['pdf', 'doc', 'docx', 'xls', 'odt', 'rtf', 'xlsx'];
            var files = e.target.files[0];
            var isSuccess = fileValidate(files, fileTypes);

            if (isSuccess) {
                var fileReader = new FileReader();
                fileReader.onload = (function (e) {
                    var file = e.target;
                    $("<div class=\"row row-eq-height\"> <div class=\"col-12 col-md-12 col-lg-10 col-xl-6 offset-xl-3 append-section timetable\">"
                        + "<div class=\"upload-input\">"
                        + "<div class=\"filename\">" + files.name + "</div>"
                        + "</div><i class=\"fas fa-times close-section close-section2\"></i></div></div>").insertAfter(".timetable-cont");
                });

                fileReader.readAsDataURL(files);
            } else {
                swal("Wrong file format", "Please upload only doc,pdf and excel files", "error");
            }
        }


        function readURLResult(e) {
            var files = e.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];

                var isSuccess = fileValidate(f, fileTypes);
                if (isSuccess) {
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("<div class=\"result_div append-section media uploaded\">" +
                            "<img class=\"img-thumbnail\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                            "<br/><i class=\"fas fa-times close-section\"></i>" +
                            "</div>").insertAfter("#upload-holder-result");
                    });
                    fileReader.readAsDataURL(f);
                } else {
                    swal("Wrong file format", "Please upload only png,jpg and gif files", "error");
                }
            }
        }

        function finish_step(type) {
            $('body').prepend('<div id="page-loader"><div class="information-box"><h4>Updating...</h4><p>This may take a minute, please do not <br/>exit or refresh this page!</p></div></div>');
            $('[name="mode"]').val(type);
            stepForm.off('submit');
            stepForm.submit();
        }

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
                    fontFamily: '"Montserrat", sans-serif',
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
                'card', stripeCard, {
                    billing_details: {name: $('[name="stripe[name]"]').val()}
                }
            );

            if (error) {
                swal("Error", error.message, "error");
            } else {
                stripeCard.clear();
                stripeCardExpiry.clear();
                stripeCardCvc.clear();
                stepForm.find('[name="paymentMethod"]').val(paymentMethod.id);
                stepForm.submit();
                return false;
            }
        }

        function headingIndex(newIndex) {
            elem = $(`#step-form-h-${newIndex}`);
            heading.find('h2').html(elem.data('title'));
            heading.find('span').html(elem.data('subtitle'));
        }

        function fileValidate(files, fileTypes) {
            var extension = files.name.split('.').pop().toLowerCase();
            return fileTypes.indexOf(extension) > -1;
        }

        function removeCoupon() {
            $('input[name="coupon_code"], #c_code').val('');
            $('#coupon-section').removeClass('d-none');
            $('#coupon-success-msg').addClass('d-none');
            $('[data-current-amt]').text($('[name=frequency]:checked').data('amount'));
            $('[data-offer-price]').text($('[name=frequency]:checked').data('offer'));
        }

        function mediaDZInit() {
            $("#mediaDropzone").dropzone({
                autoProcessQueue: true,
                uploadMultiple: true,
                parallelUploads: 1,
                url: "{!! route('dropzone.upload') !!}",
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function () {
                    if (media_images.length) {
                        $.map(media_images, function (file, key) {
                            const html = $.templates.mediaUpload({FILEURL: `${thumb_storagePath}/${file}`, FILENAME: file});
                            $(html).insertAfter("#mediaDropzone");
                        });
                    }
                },
                success: function (file, res) {
                    $.each(res, function (k, r){
                        const html = $.templates.mediaUpload({FILEURL: r.name, FILENAME: r.original_name});
                        $(html).insertAfter("#mediaDropzone");
                    });
                },
                error: function (file, response) {
                    console.log(file);
                    console.log(response);
                }
            });
        }

        $(document).ready(function () {

            stepForm.on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: stepForm.attr('action'),
                    method: 'POST',
                    data: stepForm.serialize(),
                    beforeSend: function () {
                        stepForm.find('.join-now').html('Loading...');
                        stepForm.find('.join-now').attr('disabled', true);
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
                        stepForm.find('.join-now').html('Join');
                        stepForm.find('.join-now').attr('disabled', false);
                    },
                    error: function (res) {
                        swal("Error", res.responseJSON.message, "error");
                    },
                });
                return false;
            });

            setTimeout(function () {
                $('body').on('click', '#remove-coupon', function () {
                    removeCoupon();
                });

                $('#apply-coupon').on('click', function () {
                    var $this = $(this);
                    $.ajax({
                        async: false,
                        url: "{{ route('validate.business.coupon') }}",
                        method: 'post',
                        data: {
                            'code': $('#c_code').val(),
                            'business_id': '{{ @$business->id }}',
                            'amount': $('[name=frequency]:checked').data('amount'),
                            'period': $('[name=frequency]:checked').data('period'),
                            'offer_price': $('[name=frequency]:checked').data('offer'),
                        },
                        beforeSend: function () {
                            $('#coupon-success-msg, #coupon-error-msg').html('');
                        },
                        success: function (result) {
                            $('input[name="coupon_code"]').val(result.code);
                            $('#coupon-section').addClass('d-none');
                            $('#coupon-success-msg').removeClass('d-none').html('Coupon Accepted - ' + result.offer + ' off ' + result.period + ' Payments <a href="javascript:void(0)" id="remove-coupon"><i class="fa fa-trash text-white" aria-hidden="true"></i></a>');
                            $('[data-current-amt]').text(result.amount);
                            $('[data-offer-price]').text(result.offer_price);
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

            $('body').on('click', '.close-section', function () {
                $(this).closest(".append-section").remove();
            });
            stepForm.steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",
                titleTemplate: 'Step #index#',
                enablePagination: false,
                labels: {
                    finish: "Publish Listing"
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    if (loggedUserId) {
                        headingIndex(newIndex);
                        return true;
                    }

                    var response = false;
                    $('[data-validate-field]').text('');
                    $.ajax({
                        async: false,
                        url: "{{ route('validate.business.user',[$type]) }}",
                        method: 'post',
                        data: stepForm.serialize() + "&step=" + currentIndex,
                        success: function (result) {
                            response = true;
                        },
                        error: function (xhr) {
                            var msg = $.parseJSON(xhr.responseText);

                            var errorMessage = "";
                            if (msg.errors) {
                                $.each(msg.errors, function (k, v) {
                                    if (k == 'g-recaptcha-response') {
                                        $('.form_errors').html(v);
                                    }

                                    $(`[data-validate-field=${k}]`).text(v);

                                });
                            }
                        }
                    });
                    if (response) {
                        headingIndex(newIndex);
                        if (newIndex == 1) {
                            if (typeof stripe != 'undefined') {
                                initStripe(stripe);
                            }
                        }
                        return true;
                    }
                    return false;
                },
                onStepChanged: function (event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        stepForm.find('.steps ul li.current').nextAll().removeClass("done");
                    }
                },
                onFinished: function (event, currentIndex) {
                    stripeResponseHandler();
                }
            });
            if (loggedUserId) {
                stepForm.steps('next');
                stepForm.steps('next');
                stepForm.find('.steps ul li.current').prevAll().addClass("disabled");
            }
            $("#profile_image").change(function () {
                readURL(this);
            });

            $("#cover_image").change(function () {
                readURLCover(this);
            });

            mediaDZInit();
            // $("[name='media[]']").change(function (e) {
            //     readURLMedia(e);
            // });

            // $("[name='team_img[]']").change(function (e) {
            //     readURLTeam(e);
            // });

            $("[name='listing[timetable]']").change(function (e) {
                readURLTimeTable(e);
            });

            $("[name='result[]']").change(function (e) {
                readURLResult(e);
            });

            $('body').on('change', "[name='team[file_path][]'], [name^='team_edit[file_path]']", function (e) {
                readURLTeamImage(e, $(this));
            });

            $('.btn-team').on('click', function () {
                createTeamBlock();
            });

            $('.btn-plan-selection').on('click', function () {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#step-form").offset().top
                }, 1000);
                $('.plan-selection-toggle').slideToggle();
                frequency = $('[name=frequency]:checked');
                $('[data-current-freq]').text(frequency.val());
                $('[data-current-amt]').text(frequency.data('amount'));
                $('[data-offer-price]').text(frequency.data('offer'));

                if (frequency.data('offer') && frequency.data('offer') != '0.00') {
                    $('[data-price]').text(frequency.data('offer'));
                } else {
                    $('[data-price]').text(frequency.data('amount'));
                }

                if (frequency.val() == 'yearly') {
                    $('[data-freq-short]').text('p/a');
                    $('.plan_freq').text('yearly');
                    $('[data-freq]').text('Annual');
                    $('[data-price]').text($('[data-price]').text());
                } else {
                    $('[data-freq-short]').text('p/m');
                    $('.plan_freq').text('monthly');
                    $('[data-freq]').text('Monthly');
                }

                removeCoupon();
            });


            $('.time-picker').timepicker({
                timeFormat: 'h:mm p',
                interval: 15,
                // minTime: '5',
                // maxTime: '23',
                dynamic: true,
                dropdown: true,
                scrollbar: true
            });

            $('#all_hrs').on('click', function () {
                if ($(this).is(':checked')) {
                    $('[name^="listing[timings]"].time-picker').attr('disabled', 'disabled');
                    $('[name^="listing[timings]"].timing-checkbox').prop('checked', false);
                } else {
                    $('[name^="listing[timings]"].time-picker').removeAttr('disabled');
                }
            });

            $('.btn-membership').on('click', function () {
                const UUID = $.views.helpers.UUID(),
                    optionInclude = $.templates.optionIncludes({UUID: UUID}),
                    html = $.templates.membershipOption({UUID: UUID, optionIncludes: optionInclude});
                $(html).insertAfter(".upload-membership");
            });

            $('body').on('click', '.btn-includes', function () {
                var html = $.templates.optionIncludes({UUID: $(this).closest('.append-section').data('uid')});
                $(this).closest('.member-includes').find('ul').append(html);
            });

            $('.btn-qualification').on('click', function () {
                let placeHolder = isPhysio ? 'e.g. BSc Physiotherapy' : 'e.g. Level 3 Personal Trainer';
                $("<div class='col-12 col-md-12 col-lg-6 col-xl-6 offset-xl-3 mb-3 p-0 append-section'><div class='member-qualification'>"
                    + "<input class='form-control' placeholder='" + placeHolder + "' name='qualification_options[name][]' type='text'>"
                    + "</div>"
                    + "<i class='fas fa-times close-section'></i></div></div>").insertAfter(".upload-qualification");
            });


            $("[blur-validate]").on('blur', function () {
                let _that = $(this),
                    attrName = _that.attr('name'),
                    data = {};

                if (attrName == 'password' || attrName == 'password_confirmation') {
                    data[`password_confirmation`] = $("input[name='password_confirmation']").val();
                    data[`password`] = $("input[name='password']").val();
                } else {
                    data[`${attrName}`] = _that.val();
                }

                $(`[data-validate-field="${attrName}"]`).text('');
                $.post("{{ route('validate.business.user',[$type]) }}", data).fail(function (result) {
                    if (result.status = 422) {
                        var response = result.responseJSON;

                        if (response.errors[attrName]) {
                            var emailResponse = response.errors[attrName];
                            if (emailResponse && emailResponse.length) {
                                $(`[data-validate-field="${attrName}"]`).html(emailResponse[0]);
                            }
                        }
                    }
                });
            });

            {{--$("[name='password_confirmation']").blur(function() { --}}
                {{--    var data = {name:$("[name='name']").val(),email:$("[name='email']").val(),password_confirmation:$(this).val(),password:$("[name='password']").val(), _token: '{{csrf_token()}}'};               --}}
                {{--    $.post("{{ route('validate.business.user',[$type]) }}",data).done(function(){--}}
                {{--        $('.form_errors').html('');                  --}}
                {{--    })--}}
                {{--    .fail(function(result) {--}}
                {{--        var msg = $.parseJSON(result.responseText);--}}
                {{--        var errorMessage = "";                   --}}
                {{--        $.each(msg.errors, function (k, v) {--}}
                {{--         errorMessage += "\n"+v + "<br>";--}}
                {{--        });--}}
                {{--        $('.form_errors').html(errorMessage);--}}
                {{--    }); --}}
                {{--}); --}}


            if (profile_image) {
                $('#upload-holder').css({
                    'background-image': 'url(' + storagePath + "/" + profile_image + ')',
                    'background-size': 'cover',

                }).hide().fadeIn(650);
            }

            if (cover_image) {
                $('#upload-holder-cover').css({
                    'background-image': 'url(' + storagePath + "/" + cover_image + ')',
                    'background-size': 'cover',

                }).hide().fadeIn(650);
            }
            // if (media_images.length) {
            //     $.map(media_images, function (value, key) {
            //         var file = value;
            //         var image_url = storagePath + "/" + file;
            //         $("<div class='media uploaded append-section'><img class='img-thumbnail' src='" + thumb_storagePath + "/" + file + "' title='" + file + "'/>"
            //             + "<input type='hidden' name='media_edit[]' value='" + file + "'>"
            //             + "<i class='fas fa-times close-section'></i></div>").insertAfter("#upload-holder-media");
            //     });
            // }

            if (membershipOptions.length) {
                $.map(membershipOptions, function (item) {
                    let optionIncludes = [];
                    $.map(item.includes, function (v) {
                        optionIncludes.push($.templates.optionIncludes({UUID: item.id, INCLUDE: v}));
                    });
                    const html = $.templates.membershipOption({UUID: item.id, NAME: item.name, PRICE: item.price, optionIncludes: optionIncludes.join('')});
                    $(html).insertAfter(".upload-membership");
                });
            }

            if (teamOptions.length) {
                $.map(teamOptions, function (value, key) {
                    let file = value['file_path'] ? value['file_path'] : '',
                        userId = value['user_id'] ? value['user_id'] : '',
                        userName = value['user_name'] ? value['user_name'] : '',
                        name = value['name'] ? value['name'] : '',
                        job = value['job'] ? value['job'] : '',
                        url = "{{ route('autosearch.listing',['icon','val'=>'user_id']) }}";

                    const html = $.templates.teamMember({KEY: key, NAME: name, JOB: job , URL: url, USERID : userId, USERNAME : userName , FILE:file });
                    $(html).insertAfter(".upload-team");

                    $holder = $("#file_path" + key).parent('#upload-holder');
                    if (file) {
                        var image_url = storagePath + "/" + file;
                        $holder.css({
                            'background-image': 'url(' + image_url + ')',
                            'background-size': 'cover',
                        }).hide().fadeIn(650);
                    } else {
                        $holder.append("<i class='fas fa-4x fa-user' aria-hidden='true'></i>");
                    }
                });
            }

            if (time_table) {
                $("<div class=\"row row-eq-height\"><div class=\"col-12 col-md-12 col-lg-10 col-xl-6 offset-xl-3 append-section timetable\">"
                    + "<div class=\"upload-input\">"
                    + "<div class=\"filename\">" + time_table + "</div>"
                    + "</div><i class=\"fas fa-times close-section close-section2\"></i></div></div>").insertAfter(".timetable-cont");

            }

            if (result_images.length) {
                $.map(result_images, function (value) {
                    var file = value;
                    var image_url = storagePath + "/" + file;
                    $("<div class='media uploaded append-section'><img class='img-thumbnail' src='" + thumb_storagePath + "/" + file + "' title='" + file + "'/>"
                        + "<input type='hidden' name='result_edit[]' value='" + file + "'>"
                        + "<i class='fas fa-times close-section'></i></div>").insertAfter("#upload-holder-result");
                });
            }

            if (qualificationOptions.length) {
                let placeHolder = isPhysio ? 'e.g. BSc Physiotherapy' : 'e.g. Level 3 Personal Trainer';
                $.map(qualificationOptions, function (value) {
                    $("<div class='col-12 col-md-12 col-lg-6 col-xl-6 offset-xl-3 mb-3 p-0 append-section'><div class='member-qualification'>"
                        + "<input class='form-control' placeholder='" + placeHolder + "' value='" + value + "' name='qualification_options[name][]' type='text'>"
                        + "</div>"
                        + "<i class='fas fa-times close-section'></i></div></div>").insertAfter(".upload-qualification");
                });
            }

            $('body').on('click', '.timetable .close-section', function () {
                $('#timetableFile').val(null);
            });

            if ($('.autoSelect, .iconAutoComplete').length) {
                $('.autoSelect, .iconAutoComplete').autoComplete();
            }

            $('.iconAutoComplete').on('autocomplete.select', function (evt, item) {
                $(this).closest('div').find('input:hidden').val(item.value);
            });
        });
    </script>
@endpush
