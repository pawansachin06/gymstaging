@extends('layouts.mainTable')
@section('content')
    <section class="innerpage-cont body-cont">

        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 col-xl-4 search-filter"><select class="custom-select" id="inputGroupSelect01">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select></div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-4 offset-lg-4 offset-xl-4 toggle-links"> <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">List View </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Grid View</a>
                        </li>

                    </ul></div>
                <div class="w-100"></div>
                @for($i=0; $i<15; $i++)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="list-thumb">
                            <div class="list-thumb-heading">
                        
                                Pure gym, Preston <br/>
                                <span>24 Hour Gym</span>
                            </div>
                               <div class="list-thumb-heading-right">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><br/>
                                <strong> 4 <span>(64)</span> </strong>
                            </div>
                            <div class="list-thumb-img">
                                <img src="{{ asset('/gymselect/images/gym-thumb.jpg') }}" alt=" ">
                                <img src="{{ asset('/gymselect/images/gym-logo.png') }}" alt=" ">
                            </div>
                            <div class="btn-group w-100">
                                <button type="button" class="btn thumb-btn1" data-toggle="popover"
                                        data-placement="bottom" title="Viewing Features" data-popover-content="#feature-{{$i}}">Features
                                </button>
                                <button type="button" class="btn  thumb-btn1" data-toggle="popover"
                                        data-placement="bottom" title="Map" data-popover-content="#map-{{$i}}">0.2 Miles
                                </button>
                                <a href="#" class="btn thumb-btn1 learn-more">Learn More</a>
                                <div id="feature-{{$i}}" class="d-none">
                                    <div class="popover-body">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">
                                        <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" ">

                                        <div class="row">  <span class="popover-close close btn btn1" data-target="#feature-{{$i}}">
                                        Close
                                     </span></div>
                                    </div>

                                </div>
                                <div id="map-{{$i}}" class="d-none">
                                    <div class="popover-body">
                                        <img src="{{ asset('/gymselect/images/map1.jpg') }}" alt=" ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
@push('footer_scripts')
    <script>
        $(document).ready(function () {
            $("[data-toggle=popover]").popover({
                html: true,
                trigger: 'click',
                container: 'body',
                offset:125,
                content: function () {
                    var content = $(this).attr("data-popover-content");
                    return $(content).children(".popover-body").html();
                },
                template: '<div class="popover list-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
            });

            $('.popover-close').on('click', function () {
                $($(this).data('target')).popover('hide');
            });
        });
    </script>
@endpush
