<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;
use App\Http\Helpers\AppHelper;

class FrontLayout extends Component
{
    public function render(): View
    {
        $listing = null;
        $user = auth()->user();
        $v = config('app.version');
        $routeName = Route::currentRouteName();

        $seoData = AppHelper::getPathSeo();
        $title = data_get($seoData, 'title', 'GymSelect');
        $description = data_get($seoData, 'description', '');

        if ($user && $user->business_id) {
            $listing = $user->listing;
        }

        if ($routeName === 'contact') {
            $title = 'Contact';
        }

        $needSwiper = [
            'listings.show',
        ];
        $needGlightbox = [
            'listings.show',
        ];
        $googleMaps = [
            'home',
            'listings.show',
        ];
        $recaptchas = [
        ];

        $stylesArr = [];
        $stylesArr[] = '/assets/css/lib/bootstrap.5.3.8.min.css';
        $stylesArr[] = '/assets/css/lib/sweetalert2.11.26.23.min.css';
        if (in_array($routeName, $needSwiper)) {
            $stylesArr[] = '/assets/css/lib/swiper-bundle.12.1.3.min.css';
        }
        if (in_array($routeName, $needGlightbox)) {
            $stylesArr[] = '/assets/css/lib/glightbox.3.3.1.min.css';
        }

        $stylesArr[] = "/assets/css/global.css?v=$v";

        if (in_array($routeName, ['home'])) {
            $stylesArr[] = "/assets/css/home.css?v=$v";
        } elseif (in_array($routeName, ['about'])) {
            $stylesArr[] = "/assets/css/about.css?v=$v";
        } elseif (in_array($routeName, ['listings.edit'])) {
            $stylesArr[] = "/assets/css/listings.edit.css?v=$v";
        } elseif (in_array($routeName, ['listings.show'])) {
            $stylesArr[] = "/assets/css/listings.show.css?v=$v";
        }

        $scriptsArr = [];
        $scriptsArr[] = '/assets/js/lib/popper.2.11.8.min.js';
        $scriptsArr[] = '/assets/js/lib/bootstrap.5.3.8.min.js';
        $scriptsArr[] = '/assets/js/lib/axios.1.13.6.min.js';
        $scriptsArr[] = "/assets/js/lib/sweetalert2.11.26.23.min.js";
        if (in_array($routeName, $needSwiper)) {
            $scriptsArr[] = "/assets/js/lib/swiper-bundle.12.1.3.min.js";
        }
        if (in_array($routeName, $needGlightbox)) {
            $scriptsArr[] = '/assets/js/lib/glightbox.3.3.1.min.js';
        }
        $scriptsArr[] = "/assets/js/lib/jquery.3.7.1.min.js";
        $scriptsArr[] = "/assets/js/global.js?v=$v";

        if (in_array($routeName, ['home'])) {
            $scriptsArr[] = "/assets/js/home.js?v=$v";
        } elseif (in_array($routeName, ['account.edit'])) {
            $scriptsArr[] = "/assets/js/account.js?v=$v";
        } elseif (in_array($routeName, ['listings.show'])) {
            $scriptsArr[] = "/assets/js/listings.show.js?v=$v";
        } elseif (in_array($routeName, ['join'])) {
            $scriptsArr[] = "/assets/js/join.js?v=$v";
        } elseif (in_array($routeName, ['join.service'])) {
            $scriptsArr[] = "/assets/js/join.service.js?v=$v";
        }


        $scriptsArr[] = '/assets/js/lib/alpine.3.15.11.min.js'; // alpine before Google Scripts
        if (in_array($routeName, $googleMaps)) {
            $googleMapsKey = config('services.google.maps.key');
            $scriptsArr[] = "https://maps.googleapis.com/maps/api/js?key={$googleMapsKey}&loading=async&callback=initMap&libraries=places,marker";
        }
        if (in_array($routeName, $recaptchas)) {
            $scriptsArr[] = "https://www.google.com/recaptcha/api.js";
        }

        $sidebarLinks = [
            // ['href' => route('dashboard'), 'name' => 'Dashboard'],
        ];

        return view('layouts.front', [
            'user' => $user,
            'title' => $title,
            'listing' => $listing,
            'routeName' => $routeName,
            'stylesArr' => $stylesArr,
            'scriptsArr' => $scriptsArr,
            'description' => $description,
            'sidebarLinks' => $sidebarLinks,
        ]);
    }
}