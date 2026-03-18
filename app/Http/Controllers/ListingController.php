<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Listing $listing)
    {
        //
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $listing = $user->listing;
        if (!$listing) {
            abort(500, 'Listing not found');
        }
        return view('listings.edit', [
            'item' => $listing,
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        //
    }

    public function destroy(Listing $listing)
    {
        //
    }
}
