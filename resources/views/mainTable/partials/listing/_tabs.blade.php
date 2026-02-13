@if($listing->business_id==2)
    <div class="features-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#features-tab">Services</a></li>
            @if(@$listing->qualifications->isNotEmpty())
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#qualification-tab" role="tab">Qualifications</a></li>
            @endif
            @if($listing->memberships->isNotEmpty())
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#membership-tab" role="tab">Options</a></li>
            @endif
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact-tab">Contact </a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="features-tab" role="tabpanel">
                <div class="gym-features-list">
                    <ul>
                        @if($listing->amentities)
                            @foreach($listing->amentities as $amentity)
                                <li><img src="{{ $amentity->getAmentityUrl('icon') }}" }} alt=" "> {{$amentity['name']}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="qualification-tab" role="tabpanel" aria-labelledby="qualification-tab">
                <ul class="qualification-list">
                    @php
                        $qualifications = $listing->qualifications;
                    @endphp
                    @if($qualifications->count())
                        @foreach($qualifications as $qualification)
                            <li>  {{$qualification->name}}  </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="tab-pane fade" id="membership-tab" role="tabpanel">
                <div class="row membership-cont">
                    @if($listing->memberships)
                        @foreach($listing->memberships as $membership)
                            @if($membership->name !=''|| $membership->name !=null)
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="card text-center memoption-card">
                                        <div class="card-header card-header1 text-capitalize">
                                            {{$membership->name}}
                                        </div>
                                        <div>
                                            <div class="card-body">
                                                <div class="price" data-toggle="collapse" data-target="#option_{{ $loop->index }}">
                                                    <span>{{$membership->price}}</span>
                                                    <i class="fa fa-angle-down toggle_icon"></i>
                                                </div>
                                                <ul class="list-group list-group-flush list-tick collapse" id="option_{{ $loop->index }}">
                                                    @if($membership->includes)
                                                        @foreach($membership->includes as $include)
                                                            <li class="list-group-item member-option">&nbsp;{{$include}}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @include('mainTable.partials.listing._contact')
        </div>
    </div>
@endif
@if($listing->business_id==1)
    <div class="features-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#features-tab" role="tab" aria-controls="home" aria-selected="true">Features</a></li>
            @if($listing->timeTableUrl)
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#class-tab" role="tab">Class Timetable</a></li>
            @endif
            @if(!empty(@$listing->timings))
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hours-tab" role="tab">Opening Hours</a></li>
            @endif
            @if($listing->memberships->isNotEmpty())
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#membership-tab" role="tab">Membership Options</a></li>
            @endif
            @if(@$listing->teams->isNotEmpty())
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#team-tab" role="tab">The Team </a></li>
            @endif
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact-tab" role="tab">Contact </a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="features-tab" role="tabpanel">
                <div class="gym-features-list">
                    <ul>
                        @if($listing->amentities)
                            @foreach($listing->amentities as $amentity)
                                <li>
                                    <img src="{{ $amentity->getAmentityUrl('icon') }}" }} alt=" ">
                                    <span>{{$amentity['name']}}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="class-tab" role="tabpanel">
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="mobile-timetable">
                        @if($listing->timeTableUrl)
                            <a target="_blank" href="{{$listing->timeTableUrl}}" class="btn btn2 btn-block border-radius">
                                View Class Timetable <i class="fas fa-download" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="hours-tab" role="tabpanel">
                <ul>
                    @if(in_array('ALL', $listing->timings))
                        <li><img src="{{asset('/gymselect/images/hours.png')}}" width="35"> We are Open 24/7</li>
                    @elseif($timings = $listing->timings)
                        @php
                            $days = [1=>"Monday",2=>"Tuesday",3=>"Wednesday",4=>"Thursday",5=>"Friday",6=>"Saturday",7=>"Sunday"];
                        @endphp
                        @foreach($timings as $index=>$timing)
                            <li>
                                <div class="col-8 hours-desk">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="time-hours">
                                                <p>{{@$days[$index]}}</p>
                                                <div class="time-hours1">
                                                    @if(@$timing['closed'])
                                                        <span> Closed </span>
                                                    @elseif(@$timing['start'] && @$timing['end'])
                                                        <span>{{@$timing['start']}}</span>
                                                        <span>-</span>
                                                        <span>{{@$timing['end']}} </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="tab-pane fade" id="membership-tab" role="tabpanel">
                <div class="row membership-cont">
                    @if($listing->memberships)
                        @foreach($listing->memberships as $membership)
                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="card text-center memoption-card">
                                    <div class="card-header card-header1 text-capitalize">
                                        {{$membership->name}}
                                    </div>
                                    <div>
                                        <div class="card-body">
                                            <div class="price" data-toggle="collapse" data-target="#option_{{ $loop->index }}">
                                                <span>{{$membership->price}}</span>
                                                <i class="fa fa-angle-down toggle_icon"></i>
                                            </div>
                                            <ul class="list-group list-group-flush list-tick collapse" id="option_{{ $loop->index }}">
                                                @if($membership->includes)
                                                    @foreach($membership->includes as $include)
                                                        <li class="list-group-item member-option">&nbsp;{{$include}}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="row">
                            @php
                            ($link = @$listing->links)
                            @endphp
                            @if(@$link->website)
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ $link->getUrl('website') }}" class="btn btn1 btn-block border-radius mb-2" target="_blank"> More Information </a>
                                </div>
                            @endif
                            @if($listing->signup_url)
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ $listing->getExternalUrl('signup_url') }}" class="btn btn2 btn-block border-radius" target="_blank"> Join Now ! </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="team-tab" role="tabpanel">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-5 list-mobile mt-1">
                        @if($listing->teams)
                            @foreach($listing->teams as $index=>$team)
                                <div class="mobile-team-cont">
                                    <div class="list-thumb-heading"><img src="{{ $team->getThumbUrl('file_path') }}" alt=" "> {{$team->name}} <br>
                                        <span>{{$team->job}}</span></div>
                                    @if(@$team->user->listing)
                                        <div class="list-thumb-heading-right"><a href="{{ route('listing.view',@$team->user->listing->slug) }}" class="btn btn2"> View </a></div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @include('mainTable.partials.listing._contact')
        </div>
    </div>
@endif
@if($listing->business_id==3)
    <div class="features-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#features-tab">Treatment</a>
            </li>
            @if(@$listing->qualifications->isNotEmpty())
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#qualification-tab" role="tab">Qualifications</a>
                </li>
            @endif
            @if($listing->memberships->isNotEmpty())
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#membership-tab" role="tab">Options</a></li>
            @endif
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contact-tab">Contact </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="features-tab" role="tabpanel">
                <div class="gym-features-list">
                    <ul>
                        @if($listing->amentities)
                            @foreach($listing->amentities as $amentity)
                                <li><img src="{{ $amentity->getAmentityUrl('icon') }}" }} alt=" "> {{$amentity['name']}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="qualification-tab" role="tabpanel" aria-labelledby="qualification-tab">
                <ul class="qualification-list">
                    @php
                        $qualifications = $listing->qualifications;
                    @endphp
                    @if($qualifications->count())
                        @foreach($qualifications as $qualification)
                            <li>  {{$qualification->name}}  </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="tab-pane fade" id="membership-tab" role="tabpanel">
                <div class="row membership-cont">
                    @if($listing->memberships)
                        @foreach($listing->memberships as $membership)
                            @if($membership->name !=''|| $membership->name !=null)
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="card text-center memoption-card">
                                        <div class="card-header card-header1 text-capitalize">
                                            {{$membership->name}}
                                        </div>
                                        <div>
                                            <div class="card-body">
                                                <div class="price" data-toggle="collapse" data-target="#option_{{ $loop->index }}">
                                                    <span>{{$membership->price}}</span>
                                                    <i class="fa fa-angle-down toggle_icon"></i>
                                                </div>
                                                <ul class="list-group list-group-flush list-tick collapse" id="option_{{ $loop->index }}">
                                                    @if($membership->includes)
                                                        @foreach($membership->includes as $include)
                                                            <li class="list-group-item member-option">&nbsp;{{$include}}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @include('mainTable.partials.listing._contact')
        </div>
    </div>
@endif
