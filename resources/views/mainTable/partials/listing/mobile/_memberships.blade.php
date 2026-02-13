@if($listing->memberships->isNotEmpty())
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
        <div class="row">
            <div class="mobile-section-heading">{{$listing->business_id == '1' ? 'Membership Options' : 'Options'}}</div>
        </div>
        <div class="mobile-membership">
            @foreach($listing->memberships as $index=>$membership)
                <div class="card text-center memoption-card">
                    <div class="card-header card-header1 text-capitalize">
                        <h4>{{$membership->name}}</h4>
                    </div>
                    <div id="mem_includes_{{ $loop->index }}">
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
            @endforeach
            @if($listing->business_id == 1 && $listing->signup_url)
                <div class="mb-3">
                    <a href="{{ $listing->getExternalUrl('signup_url') }}" class="btn btn3 btn-block btn-border"> Join Now</a>
                </div>
            @endif
        </div>
    </div>
@endif
