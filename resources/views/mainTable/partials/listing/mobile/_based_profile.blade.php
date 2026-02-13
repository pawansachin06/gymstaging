@if($based_profile = @$listing->address->linkedlisting)
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
        <div class="othersgym-list linked-profile">
            <ul>
                <li>
                    <div class="d-flex align-items-center view-location-block">
                            <div class="list-thumb-heading"><img
                                        src="{{ $based_profile->getThumbUrl('profile_image') }}"
                                        alt=" ">Based at {{$based_profile->name}}<br>
                                <span>{{$based_profile->category->name}}</span>
                            </div>
                            <div class="list-thumb-heading-right"><a href="{{ route('listing.view',$based_profile->slug) }}" class="btn btn2"> View </a></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endif
