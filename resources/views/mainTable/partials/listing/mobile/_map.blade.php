@php
    $address = @$listing->address;
@endphp
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
    <div class="row">
        <div class="mobile-section-heading">View Location</div>
    </div>
    <div class="mobile-map" id="listing-map"></div>
</div>
@push('footer_scripts')
    <script>
        function initListingMap() {
            var listingMap = new google.maps.Map(document.getElementById('listing-map'), {
                mapTypeControlOptions: { mapTypeIds: [] },
                zoom: 12,
                center: { lat: {!! $address->latitude !!}, lng: {!! $address->longitude !!} }
            });

            var markerImage = {
                url: '{{$listing->getMarkerUrl('profile_image')}}',
                size: new google.maps.Size(64, 64),
                scaledSize: new google.maps.Size(48, 48),
            };
            new google.maps.Marker({
                icon: markerImage,
                position: listingMap.getCenter(),
                map: listingMap
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_GEOCODING_API_KEY')}}&callback=initListingMap"></script>
@endpush
