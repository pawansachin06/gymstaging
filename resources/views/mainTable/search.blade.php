@extends('layouts.mainTable')
@push('head_scripts')
    <style>
        .body-cont {
            margin-top: 65px;
            min-height: calc(100% - 80px);
            /* Apply minus for search listing map view */
        }
    </style>
@endpush
@section('content')
    @php
    $searchLatLong = \App\Http\Helpers\AppHelper::getLatLong();
    @endphp
    <section class="innerpage-cont body-cont list-thumbs-container">
        <div class="container category-container overflow-hidden">
            {{ html()->form('GET', route('search'))->class('map-select')->id('filterForm')->open() }}
            {{ html()->hidden('b', request('b')) }}
            {{ html()->hidden('s', request('s')) }}
            {{ html()->hidden('pos', $searchLatLong) }}
            <div class="row">
                <div class="col-12 offset-md-3 col-md-6 offset-lg-4 col-lg-4 offset-xl-4 col-xl-4 mt-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filter
                        </button>
                        <div class="dropdown-menu dropdown-custom" aria-labelledby="dropdownMenuButton">
                            <div class="dropdown-item show-miles">Show locations within
                                <span>
                                    {{ html()->select('r', App\Models\ListingAddress::RADIUS_LIST, old('r', \App\Models\ListingAddress::RADIUS_DEFAULT))->class('form-control') }}
                                </span>
                                miles
                            </div>
                            <div class="dropdown-item show-miles typeheading">
                                Category
                                {{ html()->select('c[]', $categories, old('c'))->class('d-none')->id('catDropdown')->multiple() }}
                            </div>
                           
                            <div class="dropdown-item drop-custom-items" id="filter-categories">
                                <ul>
                                    @foreach ($categories as $id => $name)
                                        <li data-id="{{ $id }}"
                                            class="{{ in_array($id, request('c', [])) ? 'active' : '' }}"><a
                                                href="javascript:void(0);">{{ $name }} <i class="fa fa-"></i></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                           
                            <div class="dropdown-item drop-button" href="#">
                                <button type="button" class="btn btn-info1" onclick="javascript: resetFilter();">Reset
                                    Filters</button>
                                <button type="submit" class="btn btn-info">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ html()->form()->close() }}
            <div class="row map-list-tab">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 col-xl-4 offset-lg-4 offset-xl-4 mt-3 toggle-links">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link py-1 active" id="listview" data-toggle="pill" href="#pills-list"
                                role="tab">
                                List View
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1" id="mapview" data-toggle="pill" href="#pills-map" role="tab">Map
                                View</a>
                        </li>
                        <div class="panel"></div>
                    </ul>
                </div>
            </div>

            <div class="tab-content tab-content1">
                <!-- Panel 1 -->
                <div class="tab-pane fade in show active" id="pills-list" role="tabpanel">
                    @php $maxAdsCount = 3; @endphp
                    <div class="row mt-3" id="post-data">
                        @foreach ($queryAdsListing as $i => $queryAdsList)
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mn-blk {{ ($i + 1) > $maxAdsCount ? 'd-none' : '' }}">
                                <span class="aoc">Ad | Online Coach </span>
                                @if ($queryAdsList->verified)
                                    <span class="ver">Verified </span>
                                @endif
                                <div class="list-thumb">
                                    <div class="heading d-flex">
                                        <div class="list-thumb-heading">
                                            <img src="{{ $queryAdsList->getThumbUrl('profile_image') }}"
                                                alt="{{ $queryAdsList->name }}">
                                            {{ $queryAdsList->name }}
                                            <br />
                                            <span>{{ $queryAdsList->category->name }}</span>
                                        </div>
                                        <div class="list-thumb-heading-right w-100">
                                            {!! $queryAdsList->reviewStars !!}
                                            <div>
                                                <strong> {{ $queryAdsList->reviewAverage }}
                                                    <span>({{ $queryAdsList->reviewCount }})</span> </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-thumb-img">
    <a href="{{ route('listing.view', $queryAdsList->slug) }}">
        <img src="{{ $queryAdsList->getCoverImageUrl() }}" alt=" ">
    </a>
</div>

                                    <div class="btn-group w-100">
                                        <button type="button" class="btn thumb-btn1 features-btn" data-toggle="popover"
                                            data-placement="bottom" title="Viewing Features"
                                            data-popover-content="#feature-{{ $i }}">
                                            {{ $queryAdsList->featuresLabel }}
                                        </button>
                                        <button type="button" class="btn  thumb-btn1">Anywhere</button>
                                        <a href="{{ route('listing.view', $queryAdsList->slug) }}"
                                            class="btn thumb-btn1 learn-more">Learn
                                            More</a>
                                        <div id="feature-{{ $i }}" class="d-none">
                                            <div class="popover-body">
                                                @foreach ($queryAdsList->amentities as $amentity)
                                                    <img src="{{ asset('/storage/amenity_icons/' . $amentity['icon']) }}"
                                                        alt=" ">
                                                @endforeach
                                                <div class="row">
                                                    <span class="popover-close close btn btn1"
                                                        data-target="#feature-{{ $i }}">Close</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    @if( ($i + 1) == $maxAdsCount && count($queryAdsListing) > $maxAdsCount )
                                        <button type="button" id="view-more-ads-btn" class="btn w-100 pt-2 text-center shadow-none" style="color:#ff00ff;text-decoration:underline;font-weight:500;">View more online services</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @include('mainTable.search_listing')
                    </div>
                </div>
                <br>
                <div class="ajax-load text-center" style="display:none">
                    <p><img src="{{ asset('images/loader.gif') }}">Loading More</p>
                </div>
                <div class="tab-pane fade" id="pills-map" role="tabpanel">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer_scripts')
    @include('partials.script-niceselect')
    @include('partials.script-rating-star')
    <script>
        var storagePath = "{{ asset('/storage/') }}",
            storageAmentitiesPath = "{{ asset('/storage/amenity_icons/') }}",
            storageThumbPath = "{{ asset('/storage/thumb/') }}",
            mapElem = $('#map'),
            filterForm = $('#filterForm'),
            map,
            searchLatLong = '{{ $searchLatLong }}',
            $toggleSwitch = $('.toggle-links'),
            $togglePanel = $toggleSwitch.find('.panel'),
            panelEachWidth;
        var page = 1;
        var currenturl = new URL(window.location.href);
        $(window).scroll(function() {
            if ($(window).scrollTop() >= $('div.ajax-load').offset().top) {
                page++;
                loadMoreData(page);
            }
        });

        function reinitStar() {
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

        function addOrReplaceParam(url, param, value) {
            param = encodeURIComponent(param);
            var r = "([&?]|&amp;)" + param + "\\b(?:=(?:[^&#]*))*";
            var a = document.createElement('a');
            var regex = new RegExp(r);
            var str = param + (value ? "=" + encodeURIComponent(value) : "");
            a.href = url;
            var q = a.search.replace(regex, "$1" + str);
            if (q === a.search) {
                a.search += (a.search ? "&" : "") + str;
            } else {
                a.search = q;
            }
            return a.href;
        }

        function loadMoreData(page) {
            let route = addOrReplaceParam(currenturl, 'page', page);
            $.ajax({
                url: route,
                type: "get",
                beforeSend: function() {
                    $('.ajax-load').show();
                }
            }).done(function(data) {
                if (data.html == "") {
                    $('.ajax-load').html("No more records found");
                    return;
                }
                $('.ajax-load').hide();
                $("#post-data").append(data.html);
                reinitStar();
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('server not responding...');
            });
        }

        function _toggleSwitch() {
            $togglePanel.removeAttr('style');
            togglePanelWidth = $togglePanel.css('width').replace('px', ''),
                panelLength = $('.toggle-links li').length,

                panelEachWidth = togglePanelWidth / panelLength;
            $togglePanel.css('width', panelEachWidth + 'px');
        }

        window.addEventListener("resize", function() {
            _toggleSwitch();
        }, false);

        $(document).ready(function() {
            $(document).on('click', '#mapview', function(e) {
                $('html, body').css({
                    overflow: 'hidden',
                    height: '100%'
                });
            });
            $(document).on('click', '#listview', function(e) {
                $('html, body').css({
                    overflow: 'auto',
                    height: 'auto'
                });
            });


            _toggleSwitch();
            $toggleSwitch.find('ul li').on('click', function() {
                let index = $(this).index(),
                    leftVal = 0 + (index * panelEachWidth);
                $('body')[($(this).find('a').attr('href') == '#pills-map') ? 'addClass' : 'removeClass'](
                    'map-view-loaded');
                leftVal = (leftVal > 0) ? leftVal - 10 : leftVal + 10;
                $togglePanel.animate({
                    left: `${leftVal}px`
                });
            });
            _init_popOver();
            $('body').on('click', '[data-toggle=popover]', function() {
                _init_popOver();
                $('[data-toggle=popover]').not(this).popover('hide');
            });

            $('body').on('focus', '[data-toggle=popover]', function() {
                _init_popOver();
                $('[data-toggle=popover]').not(this).popover('hide');
            });

            $('body').on('click', '.popover-close', function() {
                $(this).closest('.list-popover').popover('hide');
            });

            $(document).on('click', '#filterForm .dropdown-menu', function(e) {
                e.stopPropagation();
            });

            $('#filter-categories li').on('click', function() {
                $(this).toggleClass('active');
                selectedValues = $('#filter-categories li.active').map(function() {
                    return $(this).data('id');
                }).get();
                filterForm.find('#catDropdown').val(selectedValues);
            });

            selectedValues = filterForm.find('#catDropdown').val();
            if (selectedValues) {
                $.map(selectedValues, function(v) {
                    $(`#filter-categories li[data-id="${v}"]`).addClass('active');
                })
            }
        });

        function _init_popOver() {
            $("[data-toggle=popover]").popover({
                html: true,
                trigger: 'click focus',
                container: 'body',
                offset: 125,
                content: function() {
                    var content = $(this).attr("data-popover-content");
                    return $(content).children(".popover-body").html();
                },
                template: '<div class="popover list-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
            });

        }

        function initMap() {
            let [defaultLat, defaultLong] = [51.5070573, -0.130622],
            [userLat, userLong] = [null, null];
            if (searchLatLong != '') {
                [defaultLat, defaultLong] = [userLat, userLong] = searchLatLong.split(',');
            }
            let map = new google.maps.Map(mapElem.get(0), {
                    zoom: 10,
                    center: new google.maps.LatLng(defaultLat, defaultLong),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }),
                bounds = new google.maps.LatLngBounds();

            const streetView = new google.maps.StreetViewPanorama(mapElem.get(0), {
                visible: false,
                enableCloseButton: true,
                addressControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_CENTER
                }
            });
            map.setStreetView(streetView);
            if (userLat && userLong) {
                let markerObj = {
                    map: map,
                    position: new google.maps.LatLng(userLat, userLong),
                    icon: {
                        url: '{{ url('/images/current_location.png') }}'
                    },
                };
                new google.maps.Marker(markerObj);
                bounds.extend(markerObj.position);
            }


            var arrLocations = [];
            var i = 0;
            if (typeof mapLocations !== 'undefined') {
                for (const [key, value] of Object.entries(mapLocations)) {
                    var profile_image = storageThumbPath + "/" + value['profile_image'],
                        listing_name = value['listing_name'],
                        listing_catname = value['listing_catname'],
                        review_star = value['review_star'],
                        review_average = value['review_average'],
                        review_count = value['review_count'],
                        profile_cover = value['profile_cover'],
                        slug = value['slug'],
                        amentities_icons = value['amentities_icons'],
                        distance_miles = value['distance_miles'],
                        marker_icon = value['marker_icon'],
                        review_stars = $('<textarea />').html(value['review_stars']).text();

                    listing_link = "{{ route('listing.view', ':slug') }}";
                    listing_link = listing_link.replace(':slug', slug);

                    var icons = '';
                    if (amentities_icons) {
                        for (var j = 0; j < amentities_icons.length; j++) {
                            icons = icons + "<img src='" + storageAmentitiesPath + "/" + amentities_icons[j] + "' alt=''>";
                        }
                    }
                    let mapPopover =
                        `<img class="map-popover" src="https://maps.googleapis.com/maps/api/staticmap?center=${value['lattitude']},${value['longitude']}&zoom=8&size=375x300&markers=icon:${marker_icon}&key={{ env('GOOGLE_GEOLOCATION_API') }}"><div class="row"><span class="popover-close close btn btn1">Close</span></div>`;
                    var map_popup = "{{ route('map.listing', ':lat,:long') }}";
                    map_popup = map_popup.replace(':lat', value['lattitude']);
                    map_popup = map_popup.replace(':long', value['longitude']);

                    var locationPin = {
                        info: "<div class=''>" +
                            "<div class='list-thumb'>" +
                            "<div class='heading d-flex'>" +
                            "<div class='list-thumb-heading'>" +
                            "<img src=" + profile_image + " >" +
                            "" + listing_name + " <br>" +
                            "<span>" + listing_catname + "</span>" +
                            "</div>" +
                            "<div class='list-thumb-heading-right w-100'>" +
                            review_stars +
                            "<strong> " + review_average + "<span>(" + review_count + ")</span> </strong>" +
                            "</div>" +
                            "</div>" +
                            "<div class='list-thumb-img'>" +
                            "<img src=" + profile_cover + " alt=''>" +
                            "</div>" +
                            "<div class='btn-group w-100'>" +
                            "<button type='button' class='btn thumb-btn1 features-btn' data-toggle='popover' data-placement='bottom' title='' data-popover-content='#popup-feature-" +
                            i + "' data-original-title='Viewing Features'>Features </button>" +
                            "<button type='button' class='btn  thumb-btn1' data-toggle='popover' data-placement='bottom' title='' data-popover-content='#popup-map-" +
                            i + "' data-original-title='Map'> " +
                            distance_miles +
                            "    Miles" +
                            "</button>" +
                            "<a href='" + listing_link + "' class='btn thumb-btn1 learn-more'>Learn More</a>" +
                            "<div id='popup-feature-" + i + "' class='d-none'>" +
                            "<div class='popover-body'>" +
                            icons +
                            "<div class='row'>" +
                            "<span class='popover-close close btn btn1' data-target='#map-feature-" + i +
                            "'>Close</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div id='popup-map-" + i + "' class='d-none'>" +
                            "<div class='popover-body'>" +
                            mapPopover +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>",
                        lat: value['lattitude'],
                        long: value['longitude'],
                        icon: marker_icon,
                    };
                    arrLocations.push(locationPin);
                    i++;
                }

                var infowindow = new google.maps.InfoWindow({
                    maxWidth: 400
                });

                $.map(arrLocations, function(item) {
                    let markerObj = {
                        map: map
                    };
                    markerObj.position = new google.maps.LatLng(item.lat, item.long);
                    markerObj.icon = {
                        url: item.icon
                    };
                    let marker = new google.maps.Marker(markerObj);
                    bounds.extend(markerObj.position);

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(item.info);
                            infowindow.open(map, marker);
                            window.initStarRating();
                        }
                    })(marker, i));
                });
                // map.fitBounds(bounds); //If enabled, Dynamic Zoom set Based upon Markers
                map.panToBounds(bounds);
            }
        }

        function resetFilter() {
            $('[name="r"]').val('{{ \App\Models\ListingAddress::RADIUS_DEFAULT }}');
            filterForm.find('#catDropdown').val('');
            filterForm[0].submit();
        }

        window.initStarRating = (function() {
            setTimeout(function() {
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
            }, 500);

        });
    </script>
    <script type="text/javascript">
        (function(){
            var viewMoreAdsBtn = document.getElementById('view-more-ads-btn');
            if(viewMoreAdsBtn) {
                viewMoreAdsBtn.addEventListener('click', function(){
                    var mnBlk = document.querySelectorAll('.mn-blk');
                    if(mnBlk) {
                        for (var i = 0; i < mnBlk.length; i++) {
                            mnBlk[i].classList.remove('d-none');
                        }
                        viewMoreAdsBtn.remove();
                    }
                });
            }
        })();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_GEOCODING_API_KEY') }}&callback=initMap"></script>
@endpush
