<div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-top-btn-cont">
    @if(auth()->check())
        <p><a href="#showcomment" id="review_btn_top" class="btn btn1 btn-block"> Add Review</a></p>
    @else
        <p><a href="{{route('auth.login')}}" id="review_btn_top" class="btn btn1 btn-block"> Add Review</a></p>
    @endif
    @php
        $link = @$listing->links;
        $ctas = @$listing->ctas;
    @endphp
{{--    @if(@$link->website)--}}
{{--        <p><a href="{{ $link->getUrl('website') }}" class="btn btn2 btn-block" target="_blank"> Visit Site</a></p>--}}
{{--    @endif--}}
    @if(@$ctas)
        @foreach($ctas as $key => $cta)
            @if(@$cta->enabled)
                <p><a href="{{ $listing->ctaLink($key, @$cta) }}" class="btn btn2 btn-block" target="_blank">{{ \App\Models\Listing::CTA_LABEL[$key] ?? @$cta->label }}</a></p>
            @endif
        @endforeach
    @endif
</div>
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-social">
    <ul>
        @if(@$link->website)
            <li><a href="{{ $link->getUrl('website') }}" target="_blank"> <img src="{{ asset('/gymselect/images/icon1.jpg') }}" alt=" "></a></li>
        @endif
        @if(@$link->email)
            <li><a href="mailto:{{ $link->email }}"> <img src="{{ asset('/gymselect/images/icon5.jpg') }}" alt=" "></a></li>
        @endif
        @if(@$link->phone)
            <li><a href="tel:{{ $link->phone }}"> <img src="{{ asset('/gymselect/images/icon3.jpg') }}" alt=" "></a></li>
        @endif
        @if(@$link->whatsapp)
            <li><a target="_blank" href="{{ @$link->whatsappUrl() }}"><img src="{{asset('/gymselect/images/icon9.png')}}" alt=" "></a></li>
        @endif
        @if(@$link->facebook)
            <li>
                <a href="{{ $link->getUrl('facebook') }}" target="_blank">
                    <img src="{{ asset('/gymselect/images/icon2.jpg') }}" alt=" ">
                </a>
            </li>
        @endif
        @if(@$link->instagram)
            <li>
                <a target="_blank" href="{{ $link->getUrl('instagram') }}"> <img src="{{ asset('/gymselect/images/icon4.jpg') }}" alt=" "></a>
            </li>
        @endif
        @if(@$link->twitter)
            <li>
                <a target="_blank" href="{{ $link->getUrl('twitter') }}"> <img src="{{ asset('/gymselect/images/icon6.jpg') }}" alt=" "></a>
            </li>
        @endif
        @if(@$link->linkedin)
            <li><a target="_blank" href="{{ @$link->getUrl('linkedin') }}"><img src="{{asset('/gymselect/images/icon8.png')}}" alt=" "></a></li>
        @endif
        @if(@$link->youtube)
            <li>
                <a target="_blank" href="{{ $link->getUrl('youtube') }}"> <img src="{{ asset('/gymselect/images/icon7.png') }}" alt=" "></a>
            </li>
        @endif
    </ul>
</div>
