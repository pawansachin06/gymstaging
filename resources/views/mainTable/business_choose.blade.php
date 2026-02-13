@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
@section('content')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto">
                    @if($type)
                        @include('partials.heading',['title'=>'Welcome','subtitle'=>'Watch the video below and click next to get started!'])
                    @else
                    @include('partials.heading',['title'=>'List Your Business','subtitle'=>'Want to feature on GymSelect? Start by selecting your business category below.'])
                    @endif

                    <div class="bg-white rounded shadow mt-5 business-join-cont">
                        <div class="px-4 py-4 show row">
                            @if($type)
                                <div class="col-12 col-md-12 col-lg-7 col-xl-7 mx-auto business-option pad-custom-0">
                                    <div class="business-option-video">
                                        <iframe src="{{ $videoURL }}?autoplay=1" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                    </div>
                                    <button type="button" class="btn btn2 btn-block btn-next-width" id="gotoform">Next</button>
                                </div>
                            @else
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto business-option pad-custom-15">
                                    <ul class="nav-selection nav nav-pills flex-column my-3">
                                        <li class="nav-item mb-2 active" data-type="gym">Gym, Club or Studio</li>
                                        <li class="nav-item mb-2" data-type="coach">PT, Coach or Instructor</li>
                                        <li class="nav-item mb-2" data-type="physio">Physio, Therapist or Chiropractor</li>
                                    </ul>
                                    <button type="button" class="btn btn2 btn-block" id="gotoform">Next</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- End rounded tabs -->
                </div>
            </div>
        </div>
        <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 80px; border-color: white; border-style:solid;"></p>


    </section>
    
@endsection

@push('footer_scripts')
    <script>
        var bizType = '{{ $type }}';
        $(document).ready(function () {
            $('.nav-selection li').on('click', function () {
                $('.nav-selection li').removeClass('active');
                $(this).addClass('active');
            });
            $('#gotoform').on('click', function () {
                let route;
                if (bizType) {
                    route = '{{ route('join.business',':TYPE') }}';
                    route = route.replace(':TYPE', '{{ $type }}');
                } else {
                    route = '{{ route('select.business') }}?biz=' + $('.nav-selection li.active').data('type');
                }
                location.href = route;
            });
        });
    </script>
@endpush
