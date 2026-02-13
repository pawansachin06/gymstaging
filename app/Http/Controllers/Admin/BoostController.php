<?php

namespace App\Http\Controllers\Admin;

use App\Events\ListingBoosted;
use App\Http\Controllers\Controller;
use App\Models\Boost;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BoostController extends Controller
{
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Listing::with('user');

        if (!Gate::allows('boosted_access')) {
            return abort(401);
        }

        if (request('show_boosted') == 1) {
            if (!Gate::allows('boosted_access')) {
                return abort(401);
            }
            $query->where('boosted', Boost::APPROVED);
        } else {
            if (!Gate::allows('boosted_access')) {
                return abort(401);
            }
            $query->where('boosted', Boost::PENDING)->pendingboost();
        }
        $listings = $query->get();

        return view('admin.boost.index', compact('listings'));
    }

    public function verifying($id, $status)
    {
        $listing = Listing::where('id', $id)->first();
        $listing->update(['boosted' => $status != Boost::APPROVED ? Boost::PENDING : Boost::APPROVED]);
        Boost::where(['listing_id' => $id, 'status' => Boost::PENDING])->update(['status' => $status]);

        try {
            event(new ListingBoosted($listing));
        } catch (\Exception $e) {
        }
        return redirect()->route('admin.boost.index', ['show_pending' => '1']);
    }
}
