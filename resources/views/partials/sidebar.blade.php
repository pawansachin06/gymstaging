@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(2) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('quickadmin.qa_dashboard')</span>
                </a>
            </li>

            @can('user_management_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span class="title">@lang('quickadmin.user-management.title')</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @php
                            $roles = \App\Models\Role::where('id' , '!=' , 3)->get();
                        @endphp
                        @can('user_access')
                            <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.users.index') }}">
                                    <i class="fa fa-users"></i>
                                    <span class="title">
                                @lang('quickadmin.qa_all')
                            </span>
                                </a>
                            </li>
                        @endcan
                        @foreach($roles  as $role)
                            <li class="{{ ($request->segment(3) == 'users') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.users.index' , ['role' => $role->id]) }}">
                                    <i class="fa fa-users"></i>
                                    <span class="title">{{$role->title}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endcan
            @can('product_list_access')
            <li class="treeview">
                <a href="#">
                        <i class="fa fa-list"></i>
                        <span class="title">@lang('quickadmin.products_listing.title')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    @can('pcoupon_access')
                        <li class="{{ $request->segment(2) == 'pcoupon' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.pcoupon.index') }}">
                                <i class="fa fa-tag"></i>
                                <span class="title">
                                @lang('quickadmin.coupons.title')
                        </span>
                            </a>
                        </li>
                    @endcan
                    @can('pcoupon_access')
                        <li class="{{ $request->segment(2) == 'products' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.products.index') }}">
                                <i class="fa fa-product-hunt"></i>
                                <span class="title">
                                @lang('quickadmin.products.title')
                        </span>
                            </a>
                        </li>
                    @endcan
                    @can('pcoupon_access')
                        <li class="treeview {{ $request->segment(2) == 'product-orders' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.product_order.index') }}?is_completed=0">
                                <i class="fa fa-list"></i>
                                <span class="title">@lang('quickadmin.product_order.title')</span>
                                <span class="pull-right-container">
                            </span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('sponser_access')
                <li class="{{ $request->segment(2) == 'sponsors' ? 'active' : '' }}">
                    <a href="{{ route('admin.sponsors.index') }}">
                        <i class="fa fa-users"></i>
                        <span class="title">@lang('quickadmin.qa_sponsership')</span>
                    </a>
                </li>
            @endcan
            @can('list_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list"></i>
                        <span class="title">@lang('quickadmin.listings.title')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('category_access')
                            <li class="{{ $request->segment(2) == 'category' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.category.index') }}">
                                    <i class="fa fa-columns"></i>
                                    <span class="title">
                                    @lang('quickadmin.category.title')
                            </span>
                                </a>
                            </li>
                        @endcan
                        @can('amenity_access')
                            <li class="{{ $request->segment(2) == 'amenity' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.amenity.index') }}">
                                    <i class="fa fa-cog"></i>
                                    <span class="title">@lang('quickadmin.amenity.title')</span>
                                </a>
                            </li>
                        @endcan
                        @can('all_access')
                            <li class="{{ $request->segment(2) == 'listings' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.listings.index') }}">
                                    <i class="fa fa-list"></i>
                                    <span class="title">All Listings</span>
                                </a>
                            </li>
                        @endcan
                        @foreach(\App\Models\Business::all() as $business)
                            <li class="{{ ($request->segment(3) == 'listings' && $request->segment(4) == $business->id ) ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.listings.index' , ['category' => $business->id]) }}">

                                    <i class="{{ $business->icon }}"></i>
                                    <span class="title">{{$business->name}}</span>
                                </a>
                            </li>
                        @endforeach
                        @can('verification_access')
                            <li class="{{ $request->segment(2) == 'verification' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.verification.index',['show_pending' => '1']) }}">
                                    <i class="fa fa-cog"></i>
                                    <span class="title">
                                        @lang('quickadmin.verification.title')
                                        @if($verifyCount = \App\Models\Verification::where('status', \App\Models\Verification::PENDING)->groupBy('listing_id')->count())
                                            <span class="badge label-danger pull-right">{{ $verifyCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('boosted_access')
                            <li class="{{ $request->segment(2) == 'boost' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.boost.index',['show_pending' => '1']) }}">
                                    <i class="fa fa-cog"></i>
                                    <span class="title">
                                        @lang('quickadmin.boosts.title')
                                        @if($verifyCount = \App\Models\Boost::where('status', \App\Models\Boost::PENDING)->groupBy('listing_id')->count())
                                            <span class="badge label-danger pull-right">{{ $verifyCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('report_abuse__access')
                        <li class="{{ $request->segment(2) == 'report_abuse' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.review.report_abuse') }}">
                                <i class="fa fa-list"></i>
                                <span class="title">Report
                                    @if($abuseCount = \App\Models\ReportAbuse::count())
                                        <span class="badge label-danger pull-right">{{ $abuseCount }}</span>
                                    @endif
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('partner')
                        <li class="{{ $request->segment(2) == 'partner' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.partner.index') }}">
                                <i class="fa fa-list"></i>
                                <span class="title">Partner</span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('cms_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-tasks"></i>
                        <span class="title">@lang('quickadmin.cms.title')</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('about_access')
                            <li class="{{ $request->segment(3) == 'about-us' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.settings',['slug'=>'about-us']) }}">
                                    <i class="fa fa-info"></i>
                                    <span class="title">
                                @lang('quickadmin.cms_about.title')
                            </span>
                                </a>
                            </li>
                            <li class="{{ $request->segment(3) == 'terms_conditions' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.settings',['slug'=>'terms_conditions']) }}">
                                    <i class="fa fa-info"></i>
                                    <span class="title">
                                @lang('quickadmin.cms_terms_conditions.title')
                            </span>
                                </a>
                            </li>
                            <li class="{{ $request->segment(3) == 'privacy_policy' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.settings',['slug'=>'privacy_policy']) }}">
                                    <i class="fa fa-info"></i>
                                    <span class="title">
                                @lang('quickadmin.cms_privacy_policy.title')
                            </span>
                                </a>
                            </li>
{{--                            <li class="{{ $request->segment(3) == 'cookie_policy' ? 'active active-sub' : '' }}">--}}
{{--                                <a href="{{ route('admin.settings',['slug'=>'cookie_policy']) }}">--}}
{{--                                    <i class="fa fa-info"></i>--}}
{{--                                    <span class="title">--}}
{{--                                Cookie Policy--}}
{{--                            </span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('settings_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span class="title">@lang('quickadmin.setting.title')</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $request->segment(3) == 'seo' ? 'active' : '' }}">
                            <a href="{{ route('admin.seo.index') }}">
                                <i class="fa fa-reply"></i>
                                <span class="title">@lang('quickadmin.seo.title')</span>
                            </a>
                        </li>
                        @can('organization_access')
                            <li class="{{ $request->segment(3) == 'organization' ? 'active' : '' }}">
                                <a href="{{ route('admin.settings',['slug'=>'organization']) }}">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="title">Organization</span>
                                </a>
                            </li>
                        @endcan
                        @can('plan_management_access')
                            <li class="{{ $request->segment(3) == 'plan' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.businesses.plan_management') }}">
                                    <i class="fa fa-check"></i>
                                    <span class="title">
                                @lang('quickadmin.plans.title')
                            </span>
                                </a>
                            </li>
                        @endcan
                        @can('coupon_access')
                            <li class="{{ $request->segment(2) == 'verificationcoupon' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.verificationcoupon.index') }}">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">
                            @lang('quickadmin.verificationcoupons.title')
                        </span>
                                </a>
                            </li>
                        <li class="{{ $request->segment(2) == 'coupon' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.coupon.index') }}">
                                <i class="fa fa-tasks"></i>
                                <span class="title">
                            @lang('quickadmin.coupons.title')
                        </span>
                            </a>
                        </li>
                    @endcan
                    @can('faq_access')
                        <li class="{{ $request->segment(2) == 'faq' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.faq.index') }}">
                                <i class="fa fa-tasks"></i>
                                <span class="title">
                            @lang('quickadmin.faqs.title')
                        </span>
                            </a>
                        </li>
                    @endcan
                    </ul>
                </li>
            @endcan
            {{-- @can('product_order_management')
                <li class="treeview {{ $request->segment(2) == 'product-orders' ? 'active' : '' }}">
                    <a href="{{ route('admin.product_order.index') }}">
                        <i class="fa fa-list"></i>
                        <span class="title">@lang('quickadmin.product_order.title')</span>
                        <span class="pull-right-container">
                    </span>
                    </a>
                </li>
            @endcan --}}
            @can('Account_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="title">@lang('quickadmin.account.title')</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        @can('profile_access')
                            <li class="{{ $request->segment(2) == 'profile' ? 'active' : '' }}">
                                <a href="{{ route('admin.settings.profile') }}">
                                    <i class="fa fa-edit"></i>
                                    <span class="title">Profile</span>
                                </a>
                            </li>
                        @endcan
                        @can('change_password_access')
                            <li class="{{ $request->segment(2) == 'change_password' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.settings.change_password') }}">
                                    <i class="fa fa-key"></i>
                                    <span class="title">@lang('quickadmin.qa_change_password')</span>
                                </a>
                            </li>
                        @endcan
                        @can('logout_access')
                            <li>
                                <a href="#logout" onclick="$('#logout').submit();">
                                    <i class="fa fa-arrow-left"></i>
                                    <span class="title">@lang('quickadmin.qa_logout')</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('quickadmin.logout')</button>
{!! Form::close() !!}
