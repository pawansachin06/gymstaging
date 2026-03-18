@props(['user' => null, 'routeName' => null, 'listing' => null ])
<div class="offcanvas offcanvas-start" tabindex="-1" id="menu-offcanvas">
    <div class="offcanvas-header py-2 border-bottom">
        <a href="/">
            <img src="/assets/img/logo-header.png" width="180" height="35" class="object-fit-contain" alt="GymSelect" />
        </a>
        <button type="button" class="btn-close py-2 my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0 py-0">
        <div class="list-group list-group-flush fw-medium">
            <a href="/" class="list-group-item list-group-item-action">Home</a>
            <a href="/about" class="list-group-item list-group-item-action {{ $routeName == 'about' ? 'active' : ''}}">About</a>
            @guest
                <a href="/join" class="list-group-item list-group-item-action {{ $routeName == 'join' ? 'active' : ''}}">List Your Business</a>
            @endguest
            <a href="/products" class="list-group-item list-group-item-action {{ $routeName == 'products' ? 'active' : ''}}">Shop Business</a>
            <a href="/partners" class="list-group-item list-group-item-action {{ $routeName == 'partner' ? 'active' : ''}}">Partners</a>
            <a href="/contact" class="list-group-item list-group-item-action {{ $routeName == 'contact' ? 'active' : ''}}">
                Contact
            </a>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="user-offcanvas">
    <div class="offcanvas-header py-2 border-bottom">
        <a href="/">
            <img src="/assets/img/logo-header.png" width="180" height="35" class="object-fit-contain" alt="GymSelect" />
        </a>
        <button type="button" class="btn-close py-2 my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0 py-0">
        <div class="list-group list-group-flush fw-medium">
            @guest
                <a href="/login?t=Business" class="list-group-item list-group-item-action">Business Login</a>
                <a href="/login?t=Personal" class="list-group-item list-group-item-action">Personal Login</a>
            @endguest
            @auth
                @if($user->business_id)
                    <a href="/business/edit" class="list-group-item list-group-item-action">Edit Listing</a>
                @endif
                @if($listing)
                    <a href="/{{ $listing->slug }}" class="list-group-item list-group-item-action">View Listing</a>
                @endif
                <a href="{{ route('account.edit') }}" class="list-group-item list-group-item-action {{ $routeName == 'account.edit' ? 'active' : '' }}">
                    Account Info
                </a>
                @if($listing)
                    <a href="/business/boost" class="list-group-item list-group-item-action">Review Boost</a>
                    <a href="/business/location-boost" class="list-group-item list-group-item-action">Location Boost</a>
                    @if(!$listing->verified)
                        <a href="/business/verify" class="list-group-item list-group-item-action">Verify Account</a>
                    @endif
                @endif
                @if($user->role_id == 3)
                    <a href="/admin/home" class="list-group-item list-group-item-action">Dashboard</a>
                @endif
                @impersonating
                    <a href="{{ route('impersonate.leave') }}" class="list-group-item list-group-item-action">Leave as impersonation</a>
                @else
                    <form action="{{ route('auth.logout') }}" method="POST" class="">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action fw-medium text-danger border-top-0 border-start-0 border-end-0">
                            Logout
                        </button>
                    </form>
                @endImpersonating
            @endauth
        </div>
    </div>
</div>

