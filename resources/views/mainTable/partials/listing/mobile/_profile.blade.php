<div class="col-12 col-md-12 col-lg-12 col-xl-12 d-flex">
    <div class="list-thumb-heading"><img src="{{ $listing->getThumbUrl('profile_image') }}" alt=" "> {{$listing->name}} <br/>
        <span>{{$listing->category->name}}</span>
    </div>
    <div class="list-thumb-heading-right">
        {!!$listing->reviewStars !!}

        <strong>{{$listing->reviewAverage}}</strong> <span>({{$listing->reviewCount}})</span>
    </div>
</div>
