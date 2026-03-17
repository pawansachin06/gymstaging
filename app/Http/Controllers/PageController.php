<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Faq;
use App\Models\Listing;
use App\Models\Partner;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('ajax')) {
            $keyword = $request->input('q');
            $listings = Listing::query()->published()->has('user')
                ->where('name', 'LIKE', "%{$keyword}%")
                ->whereNotNull('name')->limit(6)
                ->get(['name', 'slug', 'profile_image']);
            return response()->json([
                'items' => $listings,
            ]);
        }
        $services = [
            ['name' => 'Gyms, Clubs & Studios'],
            ['name' => 'Personal Trainers & Coaches'],
            ['name' => 'Physio & Sports Therapy'],
            ['name' => 'Recovery Facilties & Clinics'],
            ['name' => 'Food, Cafés & Meal Prep'],
            ['name' => 'Nutritionists & Dieticians'],
        ];
        return view('pages.index', [
            'services' => $services,
        ]);
    }

    public function about(Request $request)
    {
        // $faqs = Faq::active()->get();
        $steps = [[
            'title' => 'Search GymSelect',
            'content' => 'Find gyms, coaches, clinics, recovery centres, food providers & more near you.',
        ], [
            'title' => 'Browse & Compare',
            'content' => 'View reviews, offerings, and exclusive member perks.',
        ], [
            'title' => 'Connect Directly',
            'content' => 'Visit the business, redeem perks, or get in touch, no middlemen.',
        ], ];
        return view('pages.about', [
            // 'faqs' => $faqs,
            'steps' => $steps,
        ]);
    }

    public function partners(Request $request)
    {
        $partners = Partner::query()->get();
        return view('pages.partners', [
            'partners' => $partners,
        ]);
    }

    public function contact(Request $request)
    {
        return view('pages.contact');
    }
}
