<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        //
    }

    public function adminIndex(Request $request)
    {
        $keyword = $request->query('q', '');
        $limit = (int) $request->input('limit', 25);
        $trashed = !empty($request->query('trashed'));
        $query = Membership::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('id', 'like', "%$keyword%");
            });
        }
        if (!empty($trashed)) {
            $query->onlyTrashed();
        }
        $paginator = $query->orderBy('id', 'desc')
            ->paginate($limit)->withQueryString();
        return view('memberships.admin.index', [
            'items' => $paginator,
            'keyword' => $keyword,
            'trashed' => $trashed,
            'page' => $paginator->currentPage(),
            'last' => $paginator->lastPage(),
            'limit' => $paginator->perPage(),
            'total' => $paginator->total(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreMembershipRequest $request)
    {
        //
    }

    public function adminStore(Request $request)
    {
        try {
            $item = Membership::create([
                'name' => 'New Membership',
                'excerpt' => '',
                'price' => 0,
                'currency_code' => 'GBP',
                'duration' => 'monthly',
                'sequence' => 10,
                'features' => [],
                'meta' => [],
            ]);
            $redirect = route('admin.memberships.edit', $item);
            return response()->json([
                'redirect' => $redirect,
                'message' => 'Loading...'
            ]);
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    public function adminEdit(Membership $membership)
    {
        return view('memberships.admin.edit', [
            'item' => $membership,
            'features' => $membership->features,
            'capabilities' => $this->getCapabilities(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        //
    }

    public function adminUpdate(Request $request, Membership $membership)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'excerpt' => ['required', 'string', 'max:255'],
            'overline' => ['nullable', 'string', 'max:100'],
            'underline' => ['nullable', 'string', 'max:100'],
            'duration' => ['required', 'in:monthly,yearly'],
            'price' => ['required', 'numeric', 'decimal:0,2'],
            'sequence' => ['required', 'numeric', 'integer', 'gte:0'],
            'features' => ['required', 'array'],
            'features.*.title' => ['nullable', 'string'],
            'is_popular' => ['boolean'],
        ]);
        try {
            $allCapabilities = array_keys($this->getCapabilities());
            $capabilities = [];
            foreach ($allCapabilities as $key) {
                $capabilities[$key] = (bool) data_get($request->capabilities, $key, false);
            }
            $input['capabilities'] = $capabilities;
            $input['features'] = array_values(array_filter(
                $input['features'],
                fn ($f) => !empty($f['title'])
            ));
            $input['is_popular'] ??= 0;
            $membership->update($input);
            return resJson('Updated successfully');
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function destroy(Membership $membership)
    {
        //
    }

    private function getCapabilities()
    {
        return [
            'can_list_on_platform' => 'List on platform',
            'can_show_in_search' => 'Show in search',
            'can_show_on_map' => 'Show on map',
            'has_dedicated_profile' => 'Dedicated profile',
            'can_access_partner_network' => 'Access partner network',
        
            'has_verified_badge' => 'Verified badge',
            'has_priority_cta' => 'Priority CTA',
            'can_show_social_reviews' => 'Show social reviews',
            'can_prioritize_best_reviews' => 'Prioritize best reviews',
            'can_use_location_boost' => 'Use location boost',
            'can_highlight_perks' => 'Highlight perks',
            'can_cross_list' => 'Cross listing',
        
            'has_custom_profile' => 'Custom profile',
            'has_photo_gallery' => 'Photo gallery',
            'has_location_boost_discount' => 'Location boost discount',
        ];
    }
}
