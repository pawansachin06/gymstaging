<?php

namespace App\Http\Controllers\Admin;

use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreListsRequest;
use App\Http\Requests\Admin\UpdateListsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Auth;
use App\Models\ReportAbuse;

class ListingsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Listing::query()->has('user');

        if($request->category){
            $query->where('business_id' , $request->category);
        }

        if (! Gate::allows('listing_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('listing_delete')) {
                return abort(401);
            }
            $query->onlyTrashed();
        }

        $listings = $query->get();

        return view('admin.listings.index', compact('listings'));
    }

    /**
     * Show the form for creating new Listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('listing_create')) {
            return abort(401);
        }

        $cities = \App\Models\City::pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $businesses = \App\Models\Business::pluck('name', 'id')->toArray();
        $users = \App\Models\User::pluck('name', 'id')->toArray();

        return view('admin.listings.create', compact('cities', 'businesses' ,'users'));
    }

    /**
     * Store a newly created Listing in storage.
     *
     * @param  \App\Http\Requests\StoreListsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListsRequest $request)
    {
        if (! Gate::allows('listing_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);

        $listing = new Listing();
        $listing->fill([
            'name' => $request->name,
            'title' => $request->meta_title,
            'business_id' => $request->business_id,
            'city_id' => $request->city_id,
            'user_id' => $request->user_id,
            'address' => $request->address,
            'keyword' => $request->meta_keyword,
            'description' => $request->meta_description
        ]);

        $listing->save();

        // $listing->businesses()->sync(array_filter((array)$request->input('businesses')));

        return redirect()->route('admin.listings.index');
    }


    /**
     * Show the form for editing Listing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('listing_edit')) {
            return abort(401);
        }

        $cities = \App\Models\City::pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $businesses = \App\Models\Business::pluck('name', 'id');
        $users = \App\Models\User::pluck('name', 'id')->toArray();

        $listing = Listing::findOrFail($id);

        return view('admin.listings.edit', compact('listing', 'cities', 'businesses' , 'users'));
    }

    /**
     * Update Listing in storage.
     *
     * @param  \App\Http\Requests\UpdateListsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListsRequest $request, $id)
    {
        if (! Gate::allows('listing_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $listing = Listing::findOrFail($id);
        $listing->fill([
            'name' => $request->name,
            'title' => $request->meta_title,
            'business_id' => $request->business_id,
            'city_id' => $request->city_id,
            'user_id' => $request->user_id,
            'address' => $request->address,
            'keyword' => $request->meta_keyword,
            'description' => $request->meta_description
        ]);
        $listing->save();

        return redirect()->route('admin.listings.index');
    }


    /**
     * Display Listing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('listing_view')) {
            return abort(401);
        }
        $listing = Listing::findOrFail($id);

        return view('admin.listings.show', compact('listing'));
    }


    /**
     * Remove Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('listing_delete')) {
            return abort(401);
        }
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('admin.listings.index');
    }

    /**
     * Delete all selected Listing at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('listing_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Listing::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
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
        if (! Gate::allows('listing_delete')) {
            return abort(401);
        }
        $listing = Listing::onlyTrashed()->findOrFail($id);
        $listing->restore();

        return redirect()->route('admin.listings.index');
    }

    /**
     * Permanently delete Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('listing_delete')) {
            return abort(401);
        }
        $listing = Listing::onlyTrashed()->findOrFail($id);
        $listing->forceDelete();

        return redirect()->route('admin.listings.index');
    }

    public function paymentListing($id)
    {
        $invoice_listings = Invoice::where('subscription_id' , $id)->get();

        return view('admin.listings.payment', compact('invoice_listings'));
    }

    public function showReviewForm(Request $request , $id)
    {
        $data['review_listings'] = ListingReview::where('listing_id' , $id)->get()
                                 ->groupBy(function($item){
                                    return $item->created_at->format('d-M-y');
                                });
        $data['id'] = $id;
        $data['request'] = $request;

        return view('admin.listings.review' , $data);
    }

    public function storeReview(Request $request, $id)
    {
        $listing_review = new ListingReview();
        $listing_review->user_id = Auth::user()->id;
        $listing_review->listing_id = $id;
        $listing_review->user_name = $request->user_name;
        $listing_review->message = $request->message;
        $listing_review->rating = $request->rating;
        $listing_review->brand = $request->brand == null?'D':$request->brand;
        $listing_review->save();

        return redirect()->back();
    }

    public function deleteReview($id)
    {
        $review = ListingReview::findOrFail($id);
        $review->delete();
        return redirect()->back();
    }

    public function reportAbuse(Request $request){
        $reports = ReportAbuse::has('review')->get();
        return view('admin.listings.report_abuse' ,compact('reports'));
    }

    public function reportAbuseDelete($id, $type){
        $report = ReportAbuse::findOrFail($id);
        if($type == 'review'){
            $review = $report->review;
            $review->delete();
        }else{
            $report->delete();
        }
        return redirect()->back();
    }

    public function verify($id)
    {
       $listing = Listing::find($id);
       $listing->verified = 1;
       $listing->save();
       return redirect()->back();
    }

    public function updateBrand(Request $request)
    {
        ListingReview::where('id', $request->id)
        ->update(['brand' => $request->brand]) ;
        
        return response()->json(true);
    }

}
