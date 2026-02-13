<?php

namespace App\Http\Controllers\Admin;

use App\Models\Listing;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Events\ListingVerified;

class VerificationController extends Controller
{
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Listing::with('user');

        if (! Gate::allows('verification_access')) {
            return abort(401);
        }

        if (request('show_verified') == 1) {
            if (! Gate::allows('verification_access')) {
                return abort(401);
            }
            $query->where('verified', Verification::APPROVED);
        } else {
            if (! Gate::allows('verification_access')) {
                return abort(401);
            }
           $query->where('verified', Verification::PENDING)->pendingverify();
        }
        $listings = $query->get();

        return view('admin.verification.index', compact('listings'));
    }

    public function verifying($id, $status)
    {
        $listing = Listing::where('id' , $id)->first();
        $listing->update(['verified' => $status!= Verification::APPROVED ? Verification::PENDING : Verification::APPROVED]);
        Verification::where(['listing_id'=>$id,'status'=>Verification::PENDING])->update(['status'=>$status]);

        try {
            event(new ListingVerified($listing));
        }catch (\Exception $e){}
        return redirect()->route('admin.verification.index',['show_pending' => '1']);
    }


    /**
     * Display Category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('verification_view')) {
            return abort(401);
        }
        $listing = Listing::findOrFail($id);
        return view('admin.verification.show', compact('listing'));
    }


    /**
     * Remove Category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('verification_delete')) {
            return abort(401);
        }
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('admin.verification.index',['show_pending' => '1']);
    }

    /**
     * Delete all selected Category at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('verification_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $listing = Listing::whereIn('id', $request->input('ids'))->get();

            foreach ($listing as $verification) {
                $verification->delete();
            }
        }
    }

    /**
     * Restore Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('verification_delete')) {
            return abort(401);
        }
        $listing = Listing::onlyTrashed()->findOrFail($id);
        $listing->restore();

        return redirect()->route('admin.verification.index',['show_pending' => '1']);
    }

    /**
     * Permanently delete Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('verification_delete')) {
            return abort(401);
        }
        $listing = Listing::onlyTrashed()->findOrFail($id);
        $listing->forceDelete();

        return redirect()->back();
    }

}
