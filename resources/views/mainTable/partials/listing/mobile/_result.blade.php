@if($listing->results->isNotEmpty())
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
        <div class="row">
            <div class="mobile-section-heading"> Results</div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section carousel-full-slider">
        <div class="owl-carousel owl-theme" id="results">
            @php
                $results = $listing->results->slice(0,count($listing->results));
            @endphp
            @foreach($results as $key=>$result)
                <div class="item"><img src="{{ $result->getUrl('file_path') }}"></div>
            @endforeach
        </div>
    </div>
@endif
