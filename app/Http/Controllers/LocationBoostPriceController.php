<?php

namespace App\Http\Controllers;

use App\Models\LocationBoostPrice;
use Exception;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class LocationBoostPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function adminIndex(Request $request)
    {
        $keyword = $request->query('q', '');
        $limit = (int) $request->input('limit', 25);
        $query = LocationBoostPrice::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('postcode', 'like', "%$keyword%")
                    ->orWhere('stripe_product_id', 'like', "%$keyword%")
                    ->orWhere('stripe_price_id', 'like', "%$keyword%")
                    ->orWhere('id', 'like', "%$keyword%");
            });
        }
        $paginator = $query->orderBy('id', 'desc')
            ->paginate($limit)->withQueryString();
        return view('location-boost-prices.admin.index', [
            'items' => $paginator,
            'keyword' => $keyword,
            'page' => $paginator->currentPage(),
            'last' => $paginator->lastPage(),
            'limit' => $paginator->perPage(),
            'total' => $paginator->total(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LocationBoostPrice $locationBoostPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocationBoostPrice $locationBoostPrice)
    {
        //
    }

    public function adminEdit(Request $request, LocationBoostPrice $locationBoostPrice)
    {
        return view('location-boost-prices.admin.edit', [
            'item' => $locationBoostPrice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocationBoostPrice $locationBoostPrice)
    {
        //
    }

    public function adminUpdate(Request $request, LocationBoostPrice $locationBoostPrice)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'postcode' => ['nullable', 'string', 'max:16'],
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);
        try {
            $isLive = $locationBoostPrice->isLive();

            if (empty($locationBoostPrice->postcode) && !empty($input['postcode'])) {
                return response()->json([
                    'message' => 'Do not enter postcode for this default price',
                ], 422);
            }

            $apiSecret = $isLive ?
                config('services.stripe.live.client_secret') :
                config('services.stripe.sandbox.client_secret');
            $stripe = new StripeClient(['api_key' => $apiSecret]);
            if (!empty($locationBoostPrice->stripe_product_id)) {
                $stripe->products->update($locationBoostPrice->stripe_product_id, [
                    'name' => $input['name'],
                ]);

                $oldAmount = $locationBoostPrice->amount;
                if ($oldAmount != $input['amount']) {
                    $currency = strtolower($locationBoostPrice->currency_code);
                    $newPrice = $stripe->prices->create([
                      'currency' => $currency,
                      'recurring' => ['interval' => 'month'],
                      'unit_amount' => $input['amount'] * 100,
                      'product' => $locationBoostPrice->stripe_product_id,
                    ]);
                    $input['stripe_price_id'] = $newPrice->id;
                }
            }
            $locationBoostPrice->update($input);
            return response()->json([
                'message' => 'Updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocationBoostPrice $locationBoostPrice)
    {
        //
    }
}
