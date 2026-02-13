@extends('layouts.mainTable')
@push('header_scripts')
    <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/owl.theme.default.min.css')}}" rel="stylesheet">
@endpush
@section('content')
    <section class="innerpage-cont body-cont list-deatils list-mobile">
        @if($listing->cover_image)
            <div class="mobile-cover">
                @if($listing->verified)
                    <span class='verified verified-mobile'>Verified </span>
                @endif
                <img src="{{ $listing->getUrl('cover_image') }}" alt="{{ $listing->name }}">
            </div>
        @endif
        <div class="listing-deatils-heading">
            <div class="container overflow-hidden">
                <div class="row">
                    @include('mainTable.partials.listing.mobile._profile')
                    @include('mainTable.partials.listing.mobile._links')
                    @include('mainTable.partials.listing.mobile._features')
                    @include('mainTable.partials.listing.mobile._media')
                    @include('mainTable.partials.listing.mobile._about')
                    @includeWhen($listing->business_id == 1,'mainTable.partials.listing.mobile._hours')
                    @include('mainTable.partials.listing.mobile._memberships')
                    @includeWhen($listing->business_id == 1,'mainTable.partials.listing.mobile._meet_the_team')
                    @includeWhen($listing->business_id == 1,'mainTable.partials.listing.mobile._timetable')
                    @includeWhen($listing->business_id == 2,'mainTable.partials.listing.mobile._result')
                    @includeWhen($listing->business_id == 2 || $listing->business_id == 3,'mainTable.partials.listing.mobile._qualification')
                    @include('mainTable.partials.listing.mobile._map')
                    @includeWhen($listing->business_id == 2 || $listing->business_id == 3,'mainTable.partials.listing.mobile._based_profile')
                    @include('mainTable.partials.listing.mobile._address')
                    @include('mainTable.partials.listing.mobile._review')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer_scripts')
    @include('partials.script-rating-star')
    <link rel='stylesheet' href="{{ asset('plugins/starr/starr.min.css') }}">
    <script src="{!!asset('plugins/starr/starr.min.js')!!}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/Scrollbar.js') }}"></script>
    <script src="{{ asset('js/readmore.min.js') }}"></script>
    <link rel='stylesheet' href="{{ asset('plugins/jquery-mentiony/jquery.mentiony.css') }}">
    <script src="{{ asset('plugins/jquery-mentiony/jquery.mentiony.js') }}"></script>
    <style>
        .checked {
            color: black;
            float: right;
        }

        .verified {
            color: white;
            background-color: #D4AF37;
            float: right;
            padding: 5px 20px;
            border-radius: 25px;
            bottom: 70px;
        }


    </style>
    <script>
        var reviewForm = $("#reviewForm"), reportForm = $('#reportForm');
        $(document).ready(function () {
            var resultCarousel = $("#results");
            resultCarousel.owlCarousel({
                loop: false,
                margin: 15,
                nav: true,
                dots: false,
                singleItem: true,
                smartSpeed: 1000,
                scrollbarType: "progress",
                navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                center: false,
                stagePadding: 10,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0,
                        stagePadding: 1,

                    },
                    600: {
                        items: 2,
                        margin: 0,
                    },
                    1000: {
                        items: 2
                    }
                }
            });

            $("#review_btn_top, #review_btn_bottom").click(function () {
                $('#reviewForm').toggle();
            });
            $('.starrr').starrr({
                max: 5
            });
            $('.starrr').on('starrr:change', function (e, value) {
                $value = $('#rating').val(value);
            });

            $('#btn-review').click(function () {
                let replyID = $('#reviewForm').find('#review_id').val();
                $.ajax({
                    url: "{{route('listings.reviewstore',[$listing->slug])}}",
                    method: 'post',
                    data: $('#reviewForm').serialize(),
                    success: function (result) {
                        $('#review_list').html(result.html);
                        swal("Success", replyID ? "Reply sent" : "Review added successfully", "success");
                    },
                    error: function (xhr) {
                        var msg = $.parseJSON(xhr.responseText);
                        var errorMessage = "";
                        $.each(msg.errors, function (k, v) {
                            errorMessage += v + "\n";
                        });
                        swal("Error", errorMessage, "error");
                    }
                });
            });

            reviewForm.find('textarea[name="message"]').mentiony({
                templates: {
                    container: '<div id="mentiony-container-[ID]" class="mentiony-container"></div>',
                    content: '<div id="mentiony-content-[ID]" class="mentiony-content" contenteditable="true"></div>',
                    popover: '<div id="mentiony-popover-[ID]" class="mentiony-popover"></div>',
                    list: '<ul id="mentiony-popover-[ID]" class="mentiony-list"></ul>',
                    listItem: '<li class="mentiony-item" data-item-id="">' +
                        '<div class="row">' +
                        '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 review-user">' +
                        '<img src="https://avatars2.githubusercontent.com/u/1859127?v=3&s=140">' +
                        '<p class="title">Company name</p>' +
                        '</div>' +
                        '</div>' +
                        '</li>',
                    normalText: '<span class="normal-text"></span>',
                    highlight: '<span class="highlight"></span>',
                    highlightContent: '<a href="[HREF]" class="mentiony-link">[TEXT]</a>',
                },
                onDataRequest: function (mode, keyword, onDataRequestCompleteCallback) {
                    if (keyword != '') {
                        $.ajax({
                            method: "GET",
                            url: "get_users?query=" + keyword,
                            dataType: "json",
                            success: function (res) {
                                onDataRequestCompleteCallback.call(this, res);
                            }
                        });
                    }
                },
                timeOut: 300,
            });

            reviewForm.on('submit', function (e) {
                $('body').prepend('<div id="page-loader"><div class="information-box"><h4>Updating...</h4><p>This may take a minute, please do not <br/>exit or refresh this page!</p></div></div>');
                e.preventDefault();
                setTimeout(function (e) {
                    let mentionText = reviewForm.find('.mention').val(),
                        replyID = reviewForm.find('#review_id').val();
                    reviewForm.find('.mention').val($('.mentiony-content').html());
                    $.ajax({
                        url: "{{route('listings.reviewstore',[$listing->slug])}}",
                        method: 'post',
                        data: reviewForm.serialize(),
                        success: function (result) {
                            $("#page-loader").remove();
                            reviewForm[0].reset();
                            $('.mentiony-content').html('');
                            $('#review_list').html(result.html);
                            reviewForm.find('.rating').starRating('setRating', 0);
                            _init_starRating();
                            _initReadMore();
                            reviewForm.hide();
                            swal("Success", replyID ? "Reply sent" : "Review added successfully", "success");
                        },
                        error: function (xhr) {
                            $("#page-loader").remove();
                            reviewForm.find('.mention').val(mentionText);
                            var msg = $.parseJSON(xhr.responseText);
                            var errorMessage = "";
                            $.each(msg.errors, function (k, v) {
                                errorMessage += v + "\n";
                            });
                            swal("Error", errorMessage, "error");
                        }
                    });
                }, 500);
                return false;
            });


            $('body').on("click", ".report-cls", function () {
                $('#table_id').val($(this).attr("data-id"));
            });

            $('body').on('submit', reportForm, function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('report.abuse')}}",
                    method: 'post',
                    data: {"table_id": $('#table_id').val(), 'message': $('#report_message').val()},
                    success: function (result) {
                        reportForm[0].reset();
                        $('#report_abuse').modal('hide');
                        swal("Success", "Report abuse sent successfully", "success");
                    },
                    error: function (xhr) {
                        var msg = $.parseJSON(xhr.responseText);
                        var errorMessage = "";
                        $.each(msg.errors, function (k, v) {
                            errorMessage += v + "\n";
                        });
                        swal("Error", errorMessage, "error");
                    }
                });
                return false;
            });

            $('.readmore-section').readmore({
                collapsedHeight: 250,
                moreLink: '<button class="btn btn3 btn-block radius read-more read-more-btn1 mx-2"> Read More</button>',
                lessLink: '<button class="btn btn3 btn-block radius read-more read-more-btn1 mx-2"> Read Less</button>'
            });

            $("#more_team").click(function () {
                var $this = $(this);
                if ($this.text() == "View More") {
                    $this.text("View Less");
                    $this.prevAll(".readmore-section-team .mobile-team-cont").removeClass('active').addClass('inactive');
                } else {
                    $this.prevAll(".readmore-section-team .mobile-team-cont").removeClass('inactive').addClass('active');
                    $this.text("View More");
                }
            });

            _initReadMore();
        });

        function clickReplay(thsId) {
            $('#replay_' + thsId).toggle();
        }

        function htmlDecode(input) {
            var e = document.createElement('textarea');
            e.innerHTML = input;
            // handle case of empty input
            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        }

        function openCommentsForm(review_id, reply = null) {
            reviewForm.show();
            $('#title').focus();
            $('html, body').animate({
                scrollTop: $("#reviewForm").offset().top
            }, 2000);

            $.get('{{route("listing.reviewedit")}}', {review_id: review_id}, function (data) {
                $('#review_id').val(data['id']);

                if (reply != null && reply != 0) {
                    $('#review_reply').val(1);
                    $('.star-field').hide();
                    $('.mentiony-content').html('');
                } else {
                    $('#review_reply').val('');
                    $('.star-field').show();
                    $('#rating').val(data['rating']);
                    $('#title').val(data['title']);
                    $('.mentiony-content').html(htmlDecode(data['message']));
                    if (data['rating'] > 0) {
                        $('.rating').starRating('setRating', data['rating']);
                    }
                }

                if (reply == 0) {
                    $('.star-field').hide();
                }

            });
        }

        function _init_starRating() {
            $(".rating-star").starRating({
                totalStars: 5,
                starShape: 'rounded',
                starSize: 18,
                emptyColor: 'lightgray',
                hoverColor: '#000000',
                activeColor: '#000000',
                useGradient: false,
                readOnly: true,
            });
        }

        function _initReadMore() {
            $('.comments .user-texts').readmore({
                collapsedHeight: 70,
                moreLink: '<a class="read-more-link" href="javascript:void(0);"> Read More</a>',
                lessLink: '<a class="read-more-link" href="javascript:void(0);"> Read Less</button>'
            });
        }
    </script>
@endpush
