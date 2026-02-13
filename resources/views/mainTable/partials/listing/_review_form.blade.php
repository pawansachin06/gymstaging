@php
    $fiveRatings = $listing->reviews->where("rating",5)->count();
@endphp
<div class="list-comments">
    <h2> {{ $listing->business_id == 1 ? 'What our members say' : 'What my clients say' }}</h2>

    <div class="list-thumb-heading-right text-left">
        {!! $listing->reviewStars !!} @if($fiveRatings) Rated 5 by {{ $fiveRatings }} People @endif
    </div>
        <p>
            @if(auth()->check())
            <button class="btn btn3 btn-block" onclick="$('#reviewForm').toggle();"> Add Review</button>
            @else
            <button onclick="location.href = '{{route('auth.login')}}'" class="btn btn3 btn-block"> Add Review</button>
            @endif
        </p>
        {!! Form::open(['method' => 'POST', 'id' => 'reviewForm' , 'route' => ['listings.reviewstore', $listing->slug], 'autocomplete' => 'off' , 'style' => 'display:none']) !!}
        <div class="panel panel-default tab-content">
            <div class="panel-body">
                <div class="row star-field">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('ratings', trans('quickadmin.listings.fields.ratings').'', ['class' => 'control-label']) !!}
                        <div class='rating'></div>
                        {!! Form::hidden('rating', old('rating',1) , ['id' => 'rating']) !!}
                        {!! Form::hidden('review_id', old('review_id') , ['id' => 'review_id']) !!}
                        {!! Form::hidden('review_reply', old('review_reply') , ['id' => 'review_reply']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('message', trans('quickadmin.listings.fields.message').'', ['class' => 'control-label']) !!}
                        {!! Form::textarea('message', old('message'), ['class' => 'mention', 'placeholder' => '', 'id' => 'review_message']) !!}
                    </div>
                </div>
                {!! Form::submit('Send', ['class' => 'btn btn2' , 'style' => 'margin-left:auto;margin-right:auto;display:block;margin-top:2%;margin-bottom:0%']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    <div id="review_list">
        @include('mainTable.partials.listing._review_listings')
    </div>
</div>
