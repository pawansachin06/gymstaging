<?php

namespace App\Http\Controllers\Admin;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreAmenitiesRequest;
use App\Http\Requests\Admin\UpdateAmenitiesRequest;


class AmenityController extends Controller
{
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Amenity::query();

        if (! Gate::allows('amenity_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('amenity_delete')) {
                return abort(401);
            }
            $query->onlyTrashed();
        }

        $amenities = $query->get();

        return view('admin.amenity.index', compact('amenities'));
    }

    /**
     * Show the form for creating new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('amenity_create')) {
            return abort(401);
        }
        
        $businesses = \App\Models\Business::pluck('name', 'id');

        return view('admin.amenity.create', compact('businesses'));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param  \App\Http\Requests\StoreAmenitiesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmenitiesRequest $request)
    {
        if (! Gate::allows('amenity_create')) {
            return abort(401);
        }

        $amenity = new Amenity();
        $amenity->name = $request->name;
        $amenity->business_id = $request->business_id;
        if($request->icon){
            $filename = time().".png";
            Storage::disk('public')->putFileAs('amenity_icons',$request->icon , $filename);
          
            $amenity->icon = $filename;
        }
        $amenity->save();
       
        return redirect()->route('admin.amenity.index');
    }


    /**
     * Show the form for editing Category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('category_edit')) {
            return abort(401);
        }
        
        $businesses = \App\Models\Business::pluck('name', 'id');

        $amenity = Amenity::findOrFail($id);

        return view('admin.amenity.edit', compact('businesses', 'amenity'));
    }

    /**
     * Update Category in storage.
     *
     * @param  \App\Http\Requests\UpdateAmenitiesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAmenitiesRequest $request, $id)
    {
        
        if (! Gate::allows('amenity_edit')) {
            return abort(401);
        }
        $amenity = Amenity::where('id' , $id)->first();
        $amenity->name = $request->name;
        $amenity->business_id = $request->business_id;
        if($request->icon){
            $filename = time().".png";
            Storage::disk('public')->putFileAs('amenity_icons',$request->icon , $filename);
            $amenity->icon = $filename;
        }
        $amenity->save();
        return redirect()->route('admin.amenity.index');
    }


    /**
     * Display Category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('category_view')) {
            return abort(401);
        }
        $amenity = Amenity::findOrFail($id);

        return view('admin.amenity.show', compact('amenity'));
    }


    /**
     * Remove Category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('amenity_delete')) {
            return abort(401);
        }
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        return redirect()->route('admin.amenity.index');
    }

    /**
     * Delete all selected Category at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('amenity_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Amenity::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function massRestore(Request $request)
    {
        if (! Gate::allows('amenity_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Amenity::onlyTrashed()->whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->restore();
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
        if (! Gate::allows('category_delete')) {
            return abort(401);
        }
        $amenity = Amenity::onlyTrashed()->findOrFail($id);
        $amenity->restore();

        return redirect()->route('admin.amenity.index');
    }

    /**
     * Permanently delete Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('amenity_delete')) {
            return abort(401);
        }
        $amenity = Amenity::onlyTrashed()->findOrFail($id);
        $amenity->forceDelete();

        return redirect()->back();
    }

}
