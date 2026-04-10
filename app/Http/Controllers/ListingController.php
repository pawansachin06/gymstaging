<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\Service;
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

    public function show(Request $request, string $countryCode, Service $service, Listing $listing)
    {
        $perPage = max(1, (int) $request->query('per-page', 5));
        $isAjax = $request->boolean('ajax');
        $model = $request->input('model');
        if ($isAjax) {
            if ($model === 'listing-review') {
                $paginator = ListingReview::query()->where('listing_id', $listing->id)
                    ->paginate($perPage, ['id', 'rating', 'message', 'user_name', 'created_at']);
                $reviews = collect($paginator->items())->map(function($item) {
                    $item->created_at_label = $item->created_at->diffForHumans();
                    return $item;
                });
                return resJson([
                    'page' => $paginator->currentPage(),
                    'last' => $paginator->lastPage(),
                    'limit' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'items' => $reviews,
                ]);
            }
        }

        $mapId = config('services.google.maps.id');
        $listingLinks = $listing->links ?? [];
        $address = $listing->address;
        $media = $listing->media;
        return view('listings.show', [
            'mapId' => $mapId,
            'media' => $media,
            'item' => $listing,
            'address' => $address,
            'listingLinks' => $listingLinks,
            'markerUrl' => $listing->marker_image_url,
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $listing = $user->listing;
        if (!$listing) {
            abort(500, 'Listing not found');
        }
        $serviceVariant = $request->input('service-variant', 'coach');
        return view('listings.edit', [
            'item' => $listing,
            'serviceVariant' => $serviceVariant,
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        //
    }

    public function verify()
    {
        return view('listings.verify', []);
    }

    public function destroy(Listing $listing)
    {
        //
    }
}
