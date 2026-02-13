@if($listing->teams->isNotEmpty())
    @php
        $teams = $listing->teams;
    @endphp
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
        <div class="row">
            <div class="mobile-section-heading">Meet The Team</div>
        </div>
        <div class="mobile-team mt-2 readmore-section-team">
            @foreach($teams as $index=>$team)
                <div class="mobile-team-cont active">
                    <div class="list-thumb-heading"><img src="{{ $team->getThumbUrl('file_path') }}" alt=" "> {{$team->name}} <br>
                        <span>{{$team->job}}</span></div>
                    @if(@$team->user->listing)
                        <div class="list-thumb-heading-right"><a href="{{ route('listing.view',@$team->user->listing->slug) }}" class="btn btn2"> View </a></div>
                    @endif
                </div>
            @endforeach
            @if($teams->count() > 3)
                <button id="more_team" button class="btn btn3 btn-block radius read-more read-more-btn1  mb-2">View More</button>
            @endif
        </div>
    </div>
@endif
