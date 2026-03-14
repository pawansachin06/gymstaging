<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;

class FrontLayout extends Component
{
    public function render(): View
    {
        $listing = null;
        $title = 'GymSelect';
        $user = auth()->user();
        $routeName = Route::currentRouteName();
        $v = config('app.version');
        
        if ($user && $user->business_id) {
            $listing = $user->listing;
        }

        if ($routeName === 'contact') {
            $title = 'Contact';
        }

        $sweetalerts = [];

        $stylesArr = [];
        $stylesArr[] = '/assets/css/lib/bootstrap.5.3.8.min.css';
        $stylesArr[] = "/assets/css/global.css?v=$v";

        if (in_array($routeName, ['about'])) {
            $stylesArr[] = "/assets/css/about.css?v=$v";
        }

        $scriptsArr = [];
        $scriptsArr[] = '/assets/js/lib/popper.2.11.8.min.js';
        $scriptsArr[] = '/assets/js/lib/bootstrap.5.3.8.min.js';

        if (in_array($routeName, $sweetalerts)) {
            $scriptsArr[] = "/js/lib/sweetalert.all.min.js?v=$v";
        }

        $scriptsArr[] = "/assets/js/lib/jquery.3.7.1.min.js";
        $scriptsArr[] = "/assets/js/global.js?v=$v";

        $scriptsArr[] = "https://www.google.com/recaptcha/api.js";

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
            'sidebarLinks' => $sidebarLinks,
        ]);
    }
}