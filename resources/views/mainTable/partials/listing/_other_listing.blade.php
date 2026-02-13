@php
    $query = \App\Models\Listing::with('category')->published();
    $latitude = $longtitude = null;
    if($listing){
        $query->where('business_id',$listing->business_id)->where('id','<>', $listing->id);
        if($address = $listing->address) {
            $latitude = $address->latitude;
            $longtitude = $address->longitude;
        }
    }
    if(!$latitude || !$longtitude) {
        list($latitude, $longtitude) = explode(',', request()->session()->get('latlong', implode(',',\App\Models\ListingAddress::DEFAULT_LATLNG)));
    }

    $query->select(['*', DB::raw("(select (ACOS(SIN(RADIANS(la.`latitude`)) * SIN(RADIANS({$latitude})) + COS(RADIANS(la.`latitude`)) * COS(RADIANS({$latitude})) *
        COS(RADIANS(la.`longitude`) - RADIANS({$longtitude}))) *
        3959) from listing_addresses la WHERE la.listing_id=listings.id) as distance")]);

    $query->having('distance', '<', 10);

    $otherListings = $query->orderBy('distance')->get();
@endphp
@if($otherListings->count())
    <div class="othersgym-list map-view">
        <h2> Also in your area </h2>
        <ul>
            @foreach($otherListings as $otherListing)
                <li>
                    <div class="d-flex align-items-center view-location-block">
                            <div class="list-thumb-heading">
                                <img src="{{ $otherListing->getThumbUrl('profile_image') }}" alt=" ">{{$otherListing->name}}<br>
                                <span>{{$otherListing->category->name}}</span>
                            </div>
                            <div class="list-thumb-heading-right"><a href="{{ route('listing.view',$otherListing->slug) }}" class="btn btn2"> View </a></div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
