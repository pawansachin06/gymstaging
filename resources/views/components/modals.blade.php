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

<div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mt-3 mb-4 text-center">
                    <p class="h5 mb-0 fw-bold" id="login-modal-label">
                         Sign in to continue
                    </p>
                    <p class="mb-0 fw-medium">Unlock exclusive perks & leave reviews.</p>
                </div>
                <form action="{{ route('auth.login') }}" method="post" data-js="form">
                    <div class="mb-3 rounded-pill shadow">
                        <input text="email" name="email" autocomplete="off" placeholder="Email" required class="form-control w-100 rounded-pill" />
                    </div>
                    <div class="mb-3 rounded-pill shadow">
                        <input type="password" name="password" autocomplete="off" placeholder="Password" required class="form-control w-100 rounded-pill" />
                    </div>
                    <p class="mb-2 text-center">
                        <a href="{{ route('auth.password.reset') }}" class="link-dark fw-medium">
                            Forgot Password
                        </a>
                    </p>
                    <input type="hidden" name="ajax" value="1" /> 
                    <button type="submit" data-js="form-btn" class="mb-3 btn btn-gradient-dark w-100 position-relative px-5 fw-medium rounded-pill">
                        <span class="d-inline-block px-2">Login</span>
                        <span data-js="loader" class="d-none position-absolute top-0 bottom-0 end-0 px-2 d-inline-flex align-items-center">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        </span>
                    </button>
                    <p class="mb-0 text-center fw-medium">
                        Don't have an account? <a href="/join" class="link-dark fw-semibold">Register</a>
                    </p>
                </form>
                <div class="position-absolute top-0 end-0 px-1 py-1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</div>
