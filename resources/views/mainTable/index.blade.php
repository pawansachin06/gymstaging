@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
@section('content')
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-6 mx-auto">
                <div class=" text-center">
                    <div class="home-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/gymselect/images/home-logo.png') }}" alt="{{config('APP_NAME')}}">
                        </a>
                    </div>

                    <div class="search-cont" id="location-form">
                        {!! Form::open([ 'action' => 'HomePageController@table', 'method' => 'get','id'=>'search-form']) !!}
                        {!! Form::hidden('pos', old('pos'),['id' => 'position']) !!}
                        {!! Form::hidden('r', old('r',150)) !!}
                        <div class="form-row">
                            <div class="input-group col-12 mb-3 location-txt" id="loc-field">
                                {!! Form::text('s', old('s'), ['class' => 'form-control', 'placeholder' => 'Enter Location or Post Code' ,'id' => 'searchTextField']) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="javascript: getLocation();">
                                        <img src="{{ asset('/gymselect/images/crosshair-target-interface.png') }}" alt="Locate" />
                                    </span>
                                </div>
                            </div>
                            <div class="input-group col-12 mb-3 location-txt" id="name-field" style="display:none;">
{{--                                    {!! Form::open([ 'action' => 'HomePageController@searchGym', 'method' => 'get','id'=>'search-name']) !!}--}}
                                {!! Form::text('','', ['class' => 'form-control', 'placeholder' => 'Enter Name' ,'id' => 'searchname','autocomplete'=>'off']) !!}
{{--                                    {!! Form::close() !!}--}}
                                <div  class="searchby-name">
                                    <ul id="searchResult"></ul>
                                </div>
                            </div>
                            <div class="input-group col-12 location-select">
                                {!! Form::select('b', \App\Models\Business::SEARCH_LABELS, null , ['placeholder' => 'I am looking for...', 'class' => 'niceselect','id'=>'businessField']) !!}
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-main">Search</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <br>
                        <div class="select-form text-primary" data-search="name">Search by Name</div>
                        <div class="select-form text-primary search-location-text" data-search="location" style="display: none;">Search by Location</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($sponsors->count() > 0)
        <section class="brand">
                <div class="container">
                    <div class="text-center"><h6 class="mb-2 mb-md-3 mb-xl-3">Sponsors</h6></div>
                      <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-6 mx-auto px-xl-5">
                    <div class="row">
                        @foreach($sponsors as $sponsor)
                            <div class="col-4 col-sm-4">
                                <div class="brand-box text-center">
                                    <a href="{{ $sponsor->website_link }}" target="_blank">
                                        <img alt="{{ $sponsor->name }}" src="{{asset('/storage/images/sponsors/'.$sponsor->logo)}}" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </section>
    @endif
@stop
@push('footer_scripts')
    @include('partials.script-niceselect')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_GEOLOCATION_API') }}&libraries=places"></script>
    <script type="text/javascript">
        var seacrhField = $('#searchTextField'),
            posField = $('#position'),
            businessField = $('#businessField');

        $('body').on('click','.select-form',function(){
            let searchBy = $(this).data('search');
            $('.location-txt, .select-form').toggle();
            $('.location-select').toggleClass('hide-out');
            if(searchBy =='name') {
                $('.location-select').addClass('overflow');
            } else{
                setTimeout(function() {
                    $('.location-select').removeClass('overflow');
                }, 500);
            }
        });

        $('#searchname').on('keyup',function(){
            $.get("{{ route('searchname') }}",{ term: $(this).val() }, function (res) {
                $('#searchResult').empty();
                $.each(res,function(k,v) {
                    $("#searchResult").append(`<li class="list-thumb"><div class="list-thumb-heading"><img src="${v.image}"/>${v.name}<br/><span>${v.category}</span></div><div class="list-thumb-heading-right"><a href="${v.slug}" class="btn btn-primary">View</a></div></li>`);
                });
            });
        }).on('focus',function() {
            // $('.logo').removeClass('invisible');
            // $('.home-logo').addClass('d-none');
            // $('.align-items-center').addClass('start');
            // $('.search-name').addClass('mar-top-80');
        }).on('blur',function() {
            // if($(this).val() == '') {
            //     $('.logo').addClass('invisible');
            //     $('.home-logo').removeClass('d-none');
            //     $('.align-items-center').removeClass('start');
            //     $('.search-name').removeClass('mar-top-80');
            // }
        });

        function showLocation(position) {
            var lat = position.coords.latitude,
                lng = position.coords.longitude;

            posField.val(`${lat},${lng}`);
            var latlng = new google.maps.LatLng(lat, lng),
                geocoder = new google.maps.Geocoder();

            geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        // var city = "", country = "";
                        // for (var i = 0; i < results.length; i++) {
                        //     if ($.inArray('locality', results[i].types) != -1) {
                        //         city = results[i].formatted_address;
                        //     } else if ($.inArray('country', results[i].types) != -1) {
                        //         country = results[i].formatted_address;
                        //     }
                        // }
                       // city = city.replace(', ' + country, '');
                        seacrhField.val(results[0].formatted_address);
                    }
                }
            });
        }

        function errorHandler(err) {
            console.log(err);
            if (err.code == 2) {
                console.log('Position is not available');
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showLocation, errorHandler, {timeout: 60000});
            } else {
                alert("Sorry, browser does not support geolocation!");
            }
        }

        function getLatLng(address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    posField.val(`${results[0].geometry.location.lat()},${results[0].geometry.location.lng()}`);
                }
            });
        }

        $(document).ready(function () {
            var searchAutoComplete = new google.maps.places.Autocomplete(seacrhField.get(0), {
                types: ['geocode'],
            });
            google.maps.event.addListener(searchAutoComplete, 'place_changed', function() {
                getLatLng(seacrhField.val());
            });

            $('#search-form').on('submit', function (e) {
                if(!seacrhField.val()){
                    swal('','Please enter location or postcode', 'error');
                    return false;
                }
                if(!posField.val()){
                    swal('','Entered location is invalid', 'error');
                    return false;
                }
                if(!businessField.val()){
                    swal('','Please select a business', 'error');
                    return false;
                }
                return true;
            });
        });
    </script>
@endpush
