@extends('layouts.mainTable')
@push('header_scripts')
    <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/owl.theme.default.min.css')}}" rel="stylesheet">
@endpush
@section('content')
    @php
        $agent = new \Jenssegers\Agent\Agent();
        $address = @$listing->address;
    @endphp
    <section class="innerpage-cont body-cont list-deatils">
        <div class="listing-deatils-heading">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-9 col-md-8 col-lg-8 col-xl-8">
                        <div class="d-flex align-items-lg-start">
                            <div class="flex-grow-1 list-thumb-heading">
                                <img src="{{ $listing->getThumbUrl('profile_image') }}" alt="{{$listing->name}}">
                                {{$listing->name}}
                                <br/>
                                <span>{{$listing->category->name}} </span>
                            </div>
                            @if($listing->verified)
                                <div>
                                    <div class='verified badge badge-pill'>Verified</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-sm-3 col-md-4 col-lg-4 col-xl-4">
                        <div class="list-thumb-heading-right text-right">
                            {!! $listing->reviewStars !!}
                            <strong>{{$listing->reviewAverage}} <span>({{$listing->reviewCount}})</span>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="listing-deatils-cont">
            <div class="container">
                <div class="row">
                    <div
                        class="left-col col-12 col-md-12 {{ ($listing->business_id != 1) ? 'col-lg-7 col-xl-7' : 'col-lg-8 col-xl-8'  }}">
                        @include('mainTable.partials.listing._media')
                        @include('mainTable.partials.listing._about')
                        @include('mainTable.partials.listing._tabs')
                        @includeWhen($listing->business_id == 2, 'mainTable.partials.listing._results')
                        @include('mainTable.partials.listing._map',['id'=>'ipad'])
                        @includeWhen($listing->business_id == 2 || $listing->business_id ==
                        3,'mainTable.partials.listing._based_profile')
                        @include('mainTable.partials.listing._review_form')
                    </div>
                    <div
                        class="right-col col-12 col-md-12 {{ ($listing->business_id != 1) ? 'col-lg-5 col-xl-5' : 'col-lg-4 col-xl-4'  }} ">
                        @include('mainTable.partials.listing._map')
                        @includeWhen($listing->business_id == 2 || $listing->business_id ==
                        3,'mainTable.partials.listing._based_profile')
                        @include('mainTable.partials.listing._other_listing')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer_scripts')
    <script>
        function initListingMap() {
            $('.list-map').each(function () {
                let listingMap = new google.maps.Map(document.getElementById($(this).attr('id')), {
                    mapTypeControlOptions: {mapTypeIds: []},
                    zoom: 12,
                    center: {
                        lat: {!! $address-> latitude !!}, lng: {!! $address -> longitude !!}
                    }
                });
                let markerImage = {
                    url: '{{$listing->getMarkerUrl('profile_image')}}',
                    size: new google.maps.Size(64, 64),
                    scaledSize: new google.maps.Size(48, 48),
                };
                new google.maps.Marker({
                    icon: markerImage,
                    position: listingMap.getCenter(),
                    map: listingMap
                });
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_GEOCODING_API_KEY')}}&callback=initListingMap"></script>
    @include('partials.script-rating-star')
    <link rel='stylesheet' href="{{ asset('plugins/starr/starr.min.css') }}">
    <script src="{!!asset('plugins/starr/starr.min.js')!!}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/Scrollbar.js') }}"></script>
    <script src="{{ asset('js/readmore.min.js') }}"></script>
    <link rel='stylesheet' href="{{ asset('plugins/jquery-mentiony/jquery.mentiony.css') }}">
    <script src="{{ asset('plugins/jquery-mentiony/jquery.mentiony.js') }}"></script>
    <script>
        var reviewForm = $("#reviewForm"),
            reportForm = $("#reportForm");
        $(document).ready(function () {
            $('.memoption-card [id^="option_"]').on('show.bs.collapse hide.bs.collapse', function (e) {
                $(e.target).closest('.memoption-card').find('.price i.fa-angle-down').toggleClass('fa-flip-vertical');
            });
            var resultCarousel = $("#results");
            resultCarousel.owlCarousel({
                loop: true,
                margin: 0,
                nav: false,
                dots: false,
                singleItem: true,
                smartSpeed: 1000,
                scrollbarType: "progress",
                center: false,
                stagePadding: 0,
                mouseDrag: false,
                responsive: {
                    0: {
                        items: 2,
                        mouseDrag: true,
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 2
                    }
                }
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
            $('body').on('submit', reportForm, function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('report.abuse')}}",
                    method: 'post',
                    data: {"table_id": $('#table_id').val(), 'message': $('#report_message').val()},
                    success: function (result) {
                        reportForm[0].reset();
                        $('#report_abuse').modal('hide');
                        swal("Success", "Report sent successfully", "success");
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
            $('body').on("click", ".report-cls", function () {
                $('#table_id').val($(this).attr("data-id"));
            });
            if ($('#cg0').length) {
                $('#cg0 .cgMoreImages').click(function () {
                    if ($('#cg0 .cgMore').css('display') == 'none') {
                        $('#cg0 .cgMore').css('display', 'block');
                        $('#cg0 .cgMoreImages .cgMoreImagesInner').html('Less');
                    } else {
                        $('#cg0 .cgMore').css('display', 'none');
                        $('#cg0 .cgMoreImages .cgMoreImagesInner').html('More');
                    }
                });
                $('#cg0 .cgGridImage:not(.cgMoreImages)').click(function () {
                    $('#cg0 .cgGridImage').removeClass('cgSelectedImage');
                    $(this).addClass('cgSelectedImage');
                    $('#cg0 .cgMainImage').empty().append($(this).find('img').clone());
                    cgResizeMain();
                });
                $('#cg0 .cgGridImage.cgMoreImages').click(function () {
                    $(this).remove();
                    $('#cg0 .cgGridImage:not(.cgMoreImages)').show();
                });
                $(window).resize(function () {
                    cgResizeMain();
                    cgMoreImages();
                });
                cgResizeMain();
                cgMoreImages();

                function cgResizeMain() {
                    $('#cg0 .cgMain img').css('width', $('#cg0 .cgWrapper').width());
                    $('#cg0 .cgMain img').css('height', $('#cg0 .cgWrapper').width() * 0.45454545454545);
                }

                function cgMoreImages() {
                    if ($('#cg0 .cgGridImage').length === 1) {
                        $('#cg0 .cgGrid').hide();
                        return;
                    }
                    $('#cg0 .cgMoreImages').next().hide();
                    var count = $('#cg0 .cgFirstLine .cgGridImage:not(.cgMoreImages)').length;
                    if (count < 10) {
                        count = 10;
                    }
                    var dim = ($('#cg0 .cgWrapper').width() - 5 * (count - 1)) / count;
                    $('#cg0 .cgGridImage img, #cg0 .cgGridImage.cgMoreImages').css({
                        width: dim + 'px',
                        height: dim + 'px'
                    });
                    var spacing = $('#cg0 .cgFirstLine .cgGridImage:nth-child(2)').offset().left - $('#cg0 .cgFirstLine .cgGridImage:first-child').offset().left - $('#cg0 .cgFirstLine .cgGridImage:first-child').width();
                    $('#cg0 .cgGridLine').each(function () {
                        if ($(this).find('.cgGridImage').length < 10) {
                            $(this).addClass('notCentered');
                            // $(this).find('.cgGridImage:not(:last-child)').css('margin-right', spacing + 'px');
                            $(this).find('.cgGridImage:not(:last-child)').css('margin-right', '5px');
                        }
                    });
                }
            }
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
                    if (reply == 0) {
                        $('.star-field').hide();
                    }
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
                collapsedHeight: 76,
                moreLink: '<a class="read-more-link" href="javascript:void(0);"> Read More</a>',
                lessLink: '<a class="read-more-link" href="javascript:void(0);"> Read Less</button>'
            });
        }
    </script>
@endpush
