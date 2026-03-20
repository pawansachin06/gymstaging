@props(['user' => null, 'routeName' => ''])
@php
    $isDark = in_array($routeName, ['home']);
@endphp
<header class="position-relative {{ $isDark ? 'bg-black' : 'bg-white shadow' }}">
    <div class="container px-1 py-1">
        <div class="row gx-1 justify-content-between align-items-center">
            <div class="col-auto">
                <button class="btn px-2 py-2 rounded-circle {{ $isDark ? 'text-white border-dark' : 'border-light' }}"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#menu-offcanvas" aria-controls="menu-offcanvas">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 -960 960 960">
                        <path d="M160-240q-17 0-28.5-11.5T120-280t11.5-28.5T160-320h640q17 0 28.5 11.5T840-280t-11.5 28.5T800-240zm0-200q-17 0-28.5-11.5T120-480t11.5-28.5T160-520h640q17 0 28.5 11.5T840-480t-11.5 28.5T800-440zm0-200q-17 0-28.5-11.5T120-680t11.5-28.5T160-720h640q17 0 28.5 11.5T840-680t-11.5 28.5T800-640z"/>
                    </svg>
                </button>
            </div>
            <div class="col-auto">
                @if(!$isDark)
                    <a href="/" class="d-inline-block py-1 rounded">
                        <img src="/assets/img/logo-header.png" width="200" height="40" class="object-fit-contain" alt="GymSelect" />
                    </a>
                @endif
            </div>
            <div class="col-auto">
                @auth
                    <button class="btn px-1 py-1 rounded-circle {{ $isDark ? 'text-white border-dark' : 'border-light' }}"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#user-offcanvas" aria-controls="user-offcanvas">
                        @if( empty($user->profile_image) )
                            <img src="https://ui-avatars.com/api/?format=png&name={{ $user->name }}" alt="{{ $user->name }}" width="36px" height="36px" class="rounded-circle user-select-none" />
                        @else
                            <img src="{{ $user->profile_image }}" alt="{{ $user->name }}" width="36px" height="36px" class="rounded-circle user-select-none" />
                        @endif
                    </button>
                @else
                    <button class="btn px-2 py-2 rounded-circle {{ $isDark ? 'text-white border-dark' : 'border-light' }}"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#user-offcanvas" aria-controls="user-offcanvas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 -960 960 960">
                            <path d="M367-527q-47-47-47-113t47-113 113-47 113 47 47 113-47 113-113 47-113-47M160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440t130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240m80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360t-111 13.5T260-306q-9 5-14.5 14t-5.5 20zm296.5-343.5Q560-607 560-640t-23.5-56.5T480-720t-56.5 23.5T400-640t23.5 56.5T480-560t56.5-23.5M480-240"/>
                        </svg>
                    </button>
                @endauth
            </div>
        </div>
    </div>
</header>