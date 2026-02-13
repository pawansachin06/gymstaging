@php
    $listing = null;
    if(auth()->check() && auth()->user()->business_id){
        $listing = auth()->user()->listing;
      
    }
@endphp
<header class="topnav  {{Request::is('search') ? "map-page" : ''}}">
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4 col-xl-4 menu-left">
                    <div class="dropdown">
                        <button class="btn menu-btn1 dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <ul>
                                <li><a class="dropdown-item" href="{{ url('/') }}"><img src="{{ asset('/gymselect/images/logo.png') }}"></a></li>
                                <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                                <li><a class="dropdown-item" href="{{route('aboutus')}}">About</a></li>
                                @if(auth()->guest())
                                    <li><a class="dropdown-item" href="{{ route('select.business') }}">List Your Business</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('products') }}">Shop Business</a></li>
                                 
                                <li><a class="dropdown-item" href="{{ route('partner') }}">Partners</a></li>
                                <li><a class="dropdown-item" href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-xl-4 logo {{ request()->routeIs('home') ? 'invisible' : '' }}">
                        <a href="{{ route('home') }}"><img src="{{ asset('/gymselect/images/logo.png') }}"></a>
                </div>

                <div class="col-12 col-md-4 col-lg-4 col-xl-4 text-right  menu-right">
                    <div class="dropdown" id="userMenuDropDown">
                        <button class="btn menu-btn2 dropdown-toggle" type="button" id="userMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(auth()->check() && $profileImage = auth()->user()->profile_image)
                                <div class="profile-avatar">
                                    <img src="{{ $profileImage }}" alt="{{ auth()->user()->name }}">
                                </div>
                            @else
                                <img src="{{ url('/gymselect/images/user-icon.png') }}" alt=" ">
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuButton">
                            <ul class="tr-dropdown">
                                <li><a class="dropdown-item" href="{{ url('/') }}"><img src="{{ asset('/gymselect/images/logo.png') }}" alt=""> </a></li>
                                @guest
                                    <li><a class="dropdown-item" href="{{ route('auth.login',['t'=> \App\Models\User::TYPE_BUSINESS]) }}">Business Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('auth.login',['t'=> \App\Models\User::TYPE_PERSONAL]) }}">Personal Login</a></li>
                                   
                                    
                                        

                                    
                                         
                                        

                                @else
                                    @php
                                        $notifications =  App\Models\Notification::where('receiver_id' , auth()->user()->id)->latest()->limit(10)->get();
                                        $unread_count = $notifications->where('mark_as_read' , 0)->count();
                                    @endphp
                                    @if(auth()->user()->business_id)
                                        <li><a class="dropdown-item" href="{{route('business.edit')}}">Edit Listing</a></li>
                                        @if($listing)
                                            <li><a class="dropdown-item" href="{{route('listing.view', $listing->slug)}}">View Listing</a></li>
                                        @endif
                                    @endif
                                    <li>
                                        @if (\App\Http\Helpers\AppHelper::isMobile() )
                                            <a class="dropdown-item" href="{{ route('review.notification') }}">
                                                Notifications <span class="float-right badge badge-pill badge-info mt-1">{{$unread_count == 0 ? '' : $unread_count }}</span>
                                            </a>
                                       @else
                                        @endif

                                    </li>
                                    {{--                                    @if(auth()->user()->listing)--}}
                                    {{--                                        <li><a class="dropdown-item" href="{{route('payments')}}">Payments</a></li>--}}
                                    {{--                                    @endif--}}
                                    
                                
                         
                                    
                                    @if(auth()->user()->role_id==3)
                                    <li><a class="dropdown-item" href= "{{route('admin.home')}}">Dashboard </a></li>
                                    @endif 
                               
                              
                                    <li><a class="dropdown-item" href="{{route('account.edit')}}">Account Info</a></li>
                                    @if(auth()->user()->business_id && auth()->user()->valid_stripe_customer)
                                        <li><a class="dropdown-item" href="{{route('account.payments')}}">View Plan</a></li>
                                    @endif
                                    @if($listing)
                                            <li><a style="color:#33b0ba" class="dropdown-item" href="{{route('business.boost')}}">Review Boost</a></li>
                                            <li><a class="dropdown-item" href="{{route('business.locationboost')}}"style="color:#47a0b4">Location Boost</a></li>
                                        @if(!$listing->verified)
                                            <li><a style="color:#e2a10f" class="dropdown-item" href="{{route('business.verify')}}">Verify Account</a></li>
                                        @endif
                                    @endif
                                    @impersonating
                                    
                                    <li><a class="dropdown-item" href="{{ route('impersonate.leave') }}">Leave as impersonation</a></li>
                                   
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('auth.logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                        @endImpersonating
                                        
                                        
                                        
                                      
                                   
                                   
                                        
                                        
                                        


                                        
    
                                          
                                    @endguest
                            </ul>
                            @auth
                                <ul class="tr-dropdown notification-dropdown d-none">
                                    <li><a class="dropdown-item" href="{{ url('/') }}"><img src="{{ asset('/gymselect/images/logo.png') }}" alt=""> </a></li>
                                    <li><a class="dropdown-item notification-heading">Notifications</a></li>
                                    @if($notifications->isEmpty())
                                        <li><a href='#' class="dropdown-item"><span class="msg_info">No Notifications Here</span></a></li>
                                    @else
                                        @foreach($notifications as $notification)
                                            <li><a href="{{route('user.read_notification' ,[$notification->id])}}"
                                                   class="{{ ($notification->mark_as_read == 0) ? 'dropdown-item unread_msg' : 'dropdown-item'}}">
                                                    <span class="msg_info">{{$notification->message}}</span>
                                                    <i class="float-right text-day">{{\Carbon\Carbon::parse($notification->created_at)->diffForHumans(null, true, true)}}</i>
                                                </a>
                                            </li>
                                        @endForeach
                                    @endif
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@push('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.notifications-toggle').on('click', function (e) {
                e.preventDefault();
                $('.tr-dropdown').toggleClass('d-none');
                return false;
            });
            $('#userMenuDropDown').on('hidden.bs.dropdown', function () {
                if (!$('.notification-dropdown').hasClass('d-none')) {
                    $('.tr-dropdown').toggleClass('d-none');
                }
            });
        });
    </script>
@endpush
