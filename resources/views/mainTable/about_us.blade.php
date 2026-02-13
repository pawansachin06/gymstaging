@extends('layouts.mainTable')
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="signup-heading about-us-custom">
                        <h2>About</h2>
                        <span>GymSelect is a search platform for the health and fitness industry.</span>
                    </div>
                    <div class="bg-white business-join-cont overflow">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 pad-0">
                            
                                <div class="video-about" style="background-image: url('https://placehold.jp/ffffff/ffffff/640x480.png');">
                                    <iframe src="https://player.vimeo.com/video/450063962" width="100%" height="100%" frameborder="0" allow="fullscreen" allowfullscreen></iframe>
                                    
                                    
                                    
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 pad-0">
                                <div class="custom-accordion faq-video">
                                    @if($faqs)
                                        <ul class="faq_accordion">
                                            @foreach($faqs as $faq)
                                                <li>
                                                    <a>{{ $faq->question }}</a>
                                                    <div class="answer">{!! nl2br($faq->answer) !!}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 80px; border-color: white; border-style:solid;"></p>
    </section>
    @push('footer_scripts')
        <script>
            $(function () {
                $('.faq_accordion a').click(function (j) {
                    var dropDown = $(this).closest('li').find('.answer');

                    $(this).closest('.faq_accordion').find('.answer').not(dropDown).slideUp();

                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                    } else {
                        $(this).closest('.faq_accordion').find('a.active').removeClass('active');
                        $(this).addClass('active');
                    }

                    dropDown.stop(false, true).slideToggle();

                    j.preventDefault();
                });
            });
            $(window).on('load',function (){
               $('.video-about').css('background-image','');
            });
        </script>
    @endpush
