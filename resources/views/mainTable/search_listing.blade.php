@php
$distances = [];
$locations = $allListings
    ->map(function ($listing) use (&$distances) {
        $address = $listing->address;
        if ($address->latitude && $address->longitude) {
            $distances[$listing->id] = number_format($listing->distance, 2);
            return [
                'lattitude' => $address->latitude,
                'longitude' => $address->longitude,
                'profile_image' => $listing->profile_image,
                'listing_name' => $listing->name,
                'listing_catname' => $listing->category->name,
                'review_average' => $listing->reviewAverage,
                'review_count' => $listing->reviewCount,
                'profile_cover' => $listing->getCoverImageUrl(),
                'slug' => $listing->slug,
                'amentities_icons' => $listing->amentities->pluck('icon'),
                'distance_miles' => $distances[$listing->id],
                'marker_icon' => $listing->getMarkerUrl('profile_image'),
                'review_stars' => str_replace("'", '&quot;', $listing->reviewStars),
            ];
        }
    })
    ->filter();
@endphp


@foreach ($listings as $i => $listing)
    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mn-blk">
        @if ($listing->verified)
            <span class="ver">Verified </span>
        @endif
        <div class="list-thumb">
            <div class="heading d-flex">
                <div class="list-thumb-heading">
                    <img src="{{ $listing->getThumbUrl('profile_image') }}" alt="{{ $listing->name }}">
                    {{ $listing->name }}
                    <br />
                    <span>{{ $listing->category->name }}</span>
                </div>
                <div class="list-thumb-heading-right w-100">
                    {!! $listing->reviewStars !!}

                    <div>
                        <strong> {{ $listing->reviewAverage }}
                            <span>({{ $listing->reviewCount }})</span> </strong>
                    </div>

                </div>
            </div>
<div class="list-thumb-img">
    <a href="{{ route('listing.view', $listing->slug) }}">
        <img src="{{ $listing->getCoverImageUrl() }}" alt=" ">
    </a>
</div>
<div class="btn-group w-100">
    <button type="button" class="btn thumb-btn1 features-btn" data-toggle="popover" data-placement="bottom"
        title="Viewing Features" data-popover-content="#feature-{{ $i }}">
        {{ $listing->featuresLabel }}
    </button>
    <button type="button" class="btn thumb-btn1">{{ @$distances[$listing->id] }} Miles</button>
    <a href="{{ route('listing.view', $listing->slug) }}" class="btn thumb-btn1 learn-more">Learn More</a>

                <div id="feature-{{ $i }}" class="d-none">
                    <div class="popover-body">
                        @foreach ($listing->amentities as $amentity)
                            <img src="{{ asset('/storage/amenity_icons/' . $amentity['icon']) }}" alt=" ">
                        @endforeach
                        <div class="row">
                            <span class="popover-close close btn btn1"
                                data-target="#feature-{{ $i }}">Close</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if ($listings->count() && $locations)
    <script type="text/javascript">
        var mapLocations = {!! json_encode($locations) !!};
    </script>
@endif
