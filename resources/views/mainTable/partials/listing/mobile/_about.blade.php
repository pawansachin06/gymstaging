@if($listing->about)
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section readmore-section">
        <div class="row">
            <div class="mobile-section-heading"> About</div>
        </div>
        <div class="mobile-about-txt">
            {!! nl2br(@$listing->about) !!}
        </div>
    </div>
@endif
