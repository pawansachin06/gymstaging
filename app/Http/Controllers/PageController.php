<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Faq;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about(Request $request)
    {
        // $faqs = Faq::active()->get();
        $steps = [
            [
                'title' => 'Search GymSelect',
                'content' => 'Find gyms, coaches, clinics, recovery centres, food providers & more near you.',
            ],
            [
                'title' => 'Browse & Compare',
                'content' => 'View reviews, offerings, and exclusive member perks.',
            ],
            [
                'title' => 'Connect Directly',
                'content' => 'Visit the business, redeem perks, or get in touch, no middlemen.',
            ],
        ];
        return view('pages.about', [
            // 'faqs' => $faqs,
            'steps' => $steps,
        ]);
    }

    public function contact(Request $request)
    {
        return view('pages.contact');
    }
}
