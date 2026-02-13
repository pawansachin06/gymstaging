@if($listing->timings)
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
        <div class="row">
            <div class="mobile-section-heading">Opening Hours</div>
        </div>
        <div class="mobile-hours">
            @if(in_array('ALL', $listing->timings))
                <div class="mobile-hours"><img src="{{asset('/gymselect/images/hours.png')}}" alt=" ">We are Open 24/7</div>
            @elseif($timings = $listing->timings)
                @php
                    $days = [1=>"Monday",2=>"Tuesday",3=>"Wednesday",4=>"Thursday",5=>"Friday",6=>"Saturday",7=>"Sunday"];
                @endphp
                @foreach($timings as $index=>$timing)
                    <div class="col-12 col-md-6 hours-mobile">
                        <div class="row">
                            <div class="time-hours">
                                <p>{{@$days[$index]}}</p>
                                @if(@$timing['closed'])
                                    <div class="time-hours1 justify-content-start"><span>Closed</span></div>
                                @elseif(@$timing['start'] && @$timing['end'])
                                    <div class="time-hours1 justify-content-between">
                                        <span>{{@$timing['start']}}  </span>
                                        <span>-</span>
                                        <span>{{@$timing['end']}} </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endif
