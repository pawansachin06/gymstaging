<div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
    <div class="row">
        <div class="mobile-section-heading">
            @if($listing->business_id==1)
                Features
            @elseif($listing->business_id==2)
                Services
            @else
                Treatments
            @endif
        </div>
    </div>
    <div class="mobile-features-list">
        <ul>
            @if($listing->amentities)
                @foreach($listing->amentities as $amentity)
                    <li class="{{ $loop->index > 5 ? 'd-none' : '' }}"><img src="{{ $amentity->getAmentityUrl('icon') }}" }} alt=" "> {{$amentity['name']}}</li>
                @endforeach
            @endif
            <button class="btn btn2 btn-block mb-2 read-more-features">Show more</button>
        </ul>
    </div>
</div>
@push('footer_scripts')
    <script>
        $(document).ready(function () {
            $('.read-more-features').on('click', function () {
                let _this = $(this);
                if (_this.hasClass('open')) {
                    _this.removeClass('open').text('Show More').closest('ul').find('li:gt(5)').addClass('d-none');
                } else {
                    _this.addClass('open').text('Show Less').closest('ul').find('li').removeClass('d-none');
                }
                return false;
            });
        });
    </script>
@endpush
