@extends('layouts.app')

@section('content')
    <a href="{{ route('admin.listings.index') }}" style="float:right" class="btn btn-default">@lang('quickadmin.qa_back_to_listing')</a>
    <h3 class="page-title">Review Listings</h3>

    {!! Form::open(['method' => 'POST', 'id' => 'reviewForm' , 'route' => ['admin.listings.reviewstore', $id], 'autocomplete' => 'off']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label>User Name </label>&nbsp;&nbsp;<i class="help-inline">By Default Logged User Name</i>
                    {!! Form::text('user_name', old('user_name') , ['class'=>'form-control','placeholder' => auth()->user()->name]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('ratings', trans('quickadmin.listings.fields.ratings').'', ['class' => 'control-label']) !!}&nbsp;
                    <div class='rating'></div>
                    {!! Form::hidden('rating', old('rating') , ['id' => 'rating']) !!}
                </div>
            </div>
            <div class="row star-field">
                <div class="col-xs-12 form-group">
                    {!! Form::radio('brand', 'F',old('brand')) !!}
                    <img src="{{ asset('/images/Facebook.png')  }}" alt=" " class="review-web-icon"> &nbsp;&nbsp;
                    {!! Form::radio('brand', 'G', old('brand') ) !!}
                    <img src="{{ asset('/images/google.png')  }}" alt=" " class="review-web-icon">&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('brand', 'F',old('brand')) !!}
                    <img src="{{ asset('/images/IMG_0585.PNG')  }}" alt=" " class="review-web-icon">&nbsp;&nbsp;

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('message', trans('quickadmin.listings.fields.message').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('message', old('message'), ['class' => 'form-control mention']) !!}
                </div>
            </div>
            {!! Form::submit('Send', ['class' => 'btn btn-danger' , 'style' => 'margin-left:auto;margin-right:auto;display:block;margin-top:2%;margin-bottom:0%']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Review
        </div>

        <div class="panel-body table-responsive">
            @foreach($review_listings as $key => $reviews)
                <ul class="timeline">
                    <li class="time-label">
                            <span class="bg-red">
                                    {{$key}}
                            </span>
                    </li>
                    @foreach($reviews as $review)
                        <li>
                            <!-- timeline icon -->
                            <i class="fa fa-envelope bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i>{{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                                <span style="float:right">{!!$review->reviewStars!!}</span>
                                <h3 class="timeline-header">
                                    <td>{{$review->title}}</td>
                                </h3>
                                <h5 class="text-capitalize">
                                    <td class='text-capitalize'>{{$review->user_name}}</td>
                                </h5>

                                <div class="timeline-body">
                                    <td>{!! html_entity_decode(@$review->message) !!}</td>
                                    <span style="float:right">
                                            <a onclick="return confirm('Are you sure?');" href="{{ route('admin.listings.reviewdelete' ,[$review->id]) }}"
                                               class="btn btn-xs btn-danger">Delete</a>
                                    </span>
                                </div>
                                <div class='rating-brand-group' data-id="{{$review->id}}">
                                    {!! Form::radio("brand_$review->id",  'F' , $review->brand=='F', ['class' => 'brand' ]) !!}
                                    <img src="{{ asset('/images/Facebook.png')  }}" alt=" " class="review-web-icon"> &nbsp;&nbsp;

                                    {!! Form::radio("brand_$review->id", 'G', $review->brand=='G', ['class' => 'brand' ] ) !!}
                                    <img src="{{ asset('/images/google.png')  }}" alt=" " class="review-web-icon"> &nbsp;&nbsp;&nbsp;


                                    {!! Form::radio("brand_$review->id", 'D', $review->brand=='D' ,['class' => 'brand' ]) !!}
                                    <img src="{{ asset('/images/IMG_0585.PNG')  }}" alt=" " class="review-web-icon">  &nbsp;&nbsp;
                                </div>
                                <div class="timeline-footer"></div>
                            </div>
                        </li>
                @endforeach
                <!-- END timeline item -->
                </ul>

            @endforeach
            <p>&nbsp;</p>

        </div>
    </div>
@stop
@push('scripts')
    @include('partials.script-rating-star')
    <script src="{!!asset('plugins/jquery-mentions-input-master/lib/jquery.elastic.js')!!}"></script>
    <script src="{!!asset('js/lodash.min.js')!!}"></script>
    <link rel='stylesheet' href="{{ asset('plugins/jquery-mentions-input-master/jquery.mentionsInput.css') }}">
    <script src="{!!asset('js/underscore.js')!!}"></script>

    <script src="{!!asset('plugins/jquery-mentions-input-master/jquery.mentionsInput.js?v=2')!!}"></script>

    <style>
        .checked {
            color: black;
            float: right;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('textarea.mention').mentionsInput({
                onDataRequest: function (mode, query, callback) {
                    $.get('/get_users', function (data) {
                        data = _.filter(data, function (item) {
                            return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                        });
                        callback.call(this, data);
                    });
                },
            });

            $("#reviewForm").on('submit', function (e) {
                $('textarea.mention').mentionsInput('val', function (text) {
                    $('textarea.mention').val(text);
                });
            });

            $('.brand').on('click', function (e) {
                var brand = $(this).val();
                var id = $(this).closest('.rating-brand-group').attr('data-id');

                $.ajax({
                    url: "{{ route('admin.listings.updateBrand') }}",
                    type: "POST",
                    data:  {'brand' : brand,'id': id },
                    success: function (result) {
                        console.log(result);
                    },
                });
            });
        });
    </script>
@endpush
