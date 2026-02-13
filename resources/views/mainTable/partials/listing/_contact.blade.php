<div class="tab-pane fade" id="contact-tab" role="tabpanel" aria-labelledby="contact-tab">
    @php
    $link = @$listing->links;
    $address = @$listing->address;
    @endphp
    <div class="row">
        @if($listing->business_id==1)
            @if(@$link->website)
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <a href="{{ $link->getUrl('website') }}" class="btn btn1 btn-block border-radius mb-2" target="_blank">Visit Site </a>
                </div>
            @endif
            @if($listing->signup_url)
            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                <a href="{{ $listing->getExternalUrl('signup_url') }}" class="btn btn2 btn-block border-radius" target="_blank">
                    Join Now !
                </a>
            </div>
            @endif
        @endif
        <div class="col-12 col-md-12 col-lg-12 col-xl-12  tab-contact-list">
            <ul>
                @if(@$link->website)
                    <li>
                        <a target="_blank" href="{{ $link->getUrl('website') }}">
                            <img src="{{asset('/gymselect/images/icon1.jpg')}}" alt=" "> {{@$link->website}}
                        </a>
                    </li>
                @endif
                @if(@$link->email)
                    <li><a href="mailto:{{ $link->email }}"> <img src="{{asset('/gymselect/images/icon5.jpg')}}" alt=" ">{{@$link->email}}</a></li>
                @endif
                @if(@$link->phone)
                    <li>
                        <a target="_blank" href="tel:{{ $link->phone }}"><img src="{{asset('/gymselect/images/icon3.jpg')}}" alt=" ">{{@$link->phone}}</a>
                    </li>
                @endif
                @if(@$link->whatsapp)
                    <li>
                        <a target="_blank" href="{{ @$link->whatsappUrl() }}">
                            <img src="{{asset('/gymselect/images/icon9.png')}}" alt=" ">{{@$link->whatsapp}}
                        </a>
                    </li>
                @endif
                <li><a href="javascript:void(0);"> <img src="{{asset('/gymselect/images/mappin.png')}}">{{ implode(', ', array_filter([@$address->name, @$address->street, @$address->city, @$address->country, @$address->postcode])) }}</a> </li>
                @if(@$link->facebook)
                    <li>
                        <a target="_blank" href="{{ $link->getUrl('facebook') }}">
                            <img src="{{asset('/gymselect/images/icon2.jpg')}}" alt=" "> {{@$link->facebook}}
                        </a>
                    </li>
                @endif
                @if(@$link->twitter)
                    <li>
                        <a target="_blank" href="{{ $link->getUrl('twitter') }}">
                            <img src="{{asset('/gymselect/images/icon6.jpg')}}" alt=" "> {{@$link->twitter}}
                        </a>
                    </li>
                @endif
                @if(@$link->linkedin)
                    <li>
                        <a target="_blank" href="{{ @$link->getUrl('linkedin') }}">
                            <img src="{{asset('/gymselect/images/icon8.png')}}" alt=" ">{{@$link->linkedin}}
                        </a>
                    </li>
                @endif
                @if(@$link->instagram)
                    <li>
                        <a target="_blank" href="{{ $link->getUrl('instagram') }}">
                            <img src="{{asset('/gymselect/images/icon4.jpg')}}" alt=" "> {{@$link->instagram}}
                        </a>
                    </li>
                @endif
                @if(@$link->youtube)
                    <li>
                        <a target="_blank" href="{{ $link->getUrl('youtube') }}"> <img src="{{ asset('/gymselect/images/icon7.png') }}" alt=" ">{{@$link->youtube}}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
