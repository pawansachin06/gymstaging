<ul>
    @if(!empty($reviews)) <!-- $listing->reviews -->
        @foreach($reviews as $review)
            @php
            $user = $review->user;
            @endphp
            <li id="review-li-{{$review->id}}">
                <div class="comments">
                    <div class="comments-head">
                        <div class="user-left">
                            {{-- <img src="{{ (@$user->profile_image) ? @$user->profile_image : asset("/gymselect/images/user-icon.png") }}" alt="{{$review->user_name ?? @$user->name}}"> --}}
                            {{ $review->user_name ?? @$user->name}}
                        </div>
                        <div class="user-right">
                            <div class="list-thumb-heading-right">
                                @if($review->brand == 'G' || $review->brand == 'G API'  )
                                    <img src="{{ asset('/images/google.png')  }}" alt=" " class="review-icon">
                                @elseif($review->brand == 'F'|| $review->brand == 'F API')
                                    <img src="{{ asset('/images/Facebook.png')  }}" alt=" " class="review-icon">
                                @else
                                    <img src="{{ asset('/images/IMG_0585.PNG')  }}" alt=" " class="review-icon">
                                @endif
                                {{-- {!!$review->reviewStars!!} --}}
                            </div>
                        </div>
                    </div>
                    <div class="user-texts">
                    @if($review->brand == 'F' || $review->brand == 'F API')
                        @if($review->message=="")
                        <p>Recommends  {!! $listing->name !!} </p>
                        @else
                        
                        <p>{!! trim(html_entity_decode(@$review->message)) !!}</p>
                        @endif
                    @elseif($review->brand == 'G' || $review->brand == 'G API')
                        @if($review->message=="")
                        <p><strong>{!! $review->rating !!} stars</strong></p>
                        @else
                        <p><strong>{!! $review->rating !!} stars</strong></p>
                        <p>{!! trim(html_entity_decode(@$review->message)) !!}</p>
                        @endif
                    @else
                        <p><strong>{!! $review->rating !!} stars</strong></p> 
                        <p>{!! trim(html_entity_decode(@$review->message)) !!}</p>
                    @endif
                    </div>
                    <div class="report-abuse w-100 d-flex">
                        <div class="comments-section">
                            <small class="mr-2 comments-weeks">{{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</small>
                            @if(auth()->check())
                                @if($listing->canReply())
                                    <a href="#" onclick="openCommentsForm({{$review->id}},1)">Reply</a>
                                @endif
                                @if($review->canReply())
                                    <span class="comments-edit">
                                        <a href="#" onclick="openCommentsForm({{$review->id}})">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </span>
                                @endif
                            @endif
                        </div>
                        <div class="my-auto custom-replay">
                            @if($repliesCount = count($review->replies))
                                <a id={{"click_show_".$review->id}} style="color:#33b0ba;" onclick="clickReplay({{$review->id}});">View Reply</a>
                            @endif
                        </div>
                        <div class="my-auto">
                            <a href='#' class="report-cls" data-toggle="modal" data-target="#report_abuse"
                               data-id='{{$review->id}}'>
                                Report
                            </a>
                        </div>
                    </div>
                </div>
                <div id={{"replay_".$review->id}} style="display:none;">
                    @foreach($review->replies as $reply)
                        @php
                            $user = $reply->user;
                        @endphp
                        <ul>
                            <li>
                                <div class="comments">
                                    <div class="user-left">
                                        <img src="{{ (@$user->profile_image) ? @$user->profile_image : asset("/gymselect/images/user-icon.png") }}" alt="{{$user->name}}">
                                        {{$user->name}}
                                    </div>
                                    <div class="user-right">
                                        <div class="list-thumb-heading-right"></div>
                                    </div>
                                    <div class="user-texts">
                                        <p>{!! html_entity_decode(@$reply['message']) !!}</p>
                                        <small class="comments-weeks"> {{\Carbon\Carbon::parse($reply['created_at'])->diffForHumans()}}</small>
                                        @if(auth()->check())
                                            @if($reply->canReply())
                                                <span class="comments-edit ">
                                                <a href="#" onclick="openCommentsForm({{$reply['id']}},0)" class="reply-edit">
                                                    <i class="fas fa-pencil-alt "></i>
                                                </a>
                                            </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </li>
        @endforeach
    @endif
</ul>
@if(!empty($reviews))
    {{ $reviews->links() }}
@endif
<style type="text/css">.comments{float:none}</style>
{{ html()->form('POST', route('report.abuse'))->id('reportForm')->open() }}
{{ html()->hidden('table_id', old('table_id'))->id('table_id') }}
<div class="modal fade" id="report_abuse" tabindex="-1" role="dialog" aria-labelledby="report_abuseLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="report_abuseLabel">Report</h4>
            </div>
            <div class="modal-body">
                <textarea name="message" id="report_message" cols="30" rows="10" placeholder='Enter message' class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn2 btn-primary report-btn">Submit</button>
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}
