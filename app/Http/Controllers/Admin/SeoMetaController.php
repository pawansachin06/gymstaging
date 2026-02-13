<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seometa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSeoMetaRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Auth;

class SeoMetaController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $query = SeoMeta::query();

        if (! Gate::allows('seometa_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('seometa_delete')) {
                return abort(401);
            }
            $query->onlyTrashed();
        }

        $seo_lists = $query->get();

        return view('admin.seo.index', compact('seo_lists'));
    }

    /**
     * Show the form for creating new Listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('seometa_create')) {
            return abort(401);
        }
        
        return view('admin.seo.create');
    }

    /**
     * Store a newly created Listing in storage.
     *
     * @param  \App\Http\Requests\StoreSeoMetaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeoMetaRequest $request)
    {
        if (! Gate::allows('seometa_create')) {
            return abort(401);
        }
    
        $seo_lists = new Seometa();
    
        $seo_lists->fill([
            'page_url' => $request->page_url,
            'title' => $request->meta_title,
            'keywords' => $request->meta_keyword,
            'description' => $request->meta_description
        ]); 
       
        $seo_lists->save();
       
        return redirect()->route('admin.seo.index');
    }


    /**
     * Show the form for editing Listing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('seometa_edit')) {
            return abort(401);
        }

        $seo_list = Seometa::findOrFail($id);

        return view('admin.seo.edit', compact('seo_list'));
    }

    /**
     * Update Listing in storage.
     *
     * @param  \App\Http\Requests\UpdateListsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSeoMetaRequest $request, $id)
    {
        if (! Gate::allows('seometa_edit')) {
            return abort(401);
        }
        $seo_lists = Seometa::findOrFail($id);
        $seo_lists->fill([
            'page_url' => $request->page_url,
            'title' => $request->meta_title,
            'keywords' => $request->meta_keyword,
            'description' => $request->meta_description
        ]); 
        $seo_lists->save();    

        return redirect()->route('admin.seo.index');
    }


    /**
     * Display Listing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('seometa_view')) {
            return abort(401);
        }
        $seo_list = SeoMeta::findOrFail($id);

        return view('admin.seo.show', compact('seo_list'));
    }


    /**
     * Remove Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('seometa_delete')) {
            return abort(401);
        }
        $seo_lists = SeoMeta::findOrFail($id);
        $seo_lists->delete();

        return redirect()->route('admin.seo.index');
    }

    /**
     * Delete all selected Listing at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('seometa_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Seometa::whereIn('id', $request->input('ids'))->get();

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
        if (! Gate::allows('seometa_delete')) {
            return abort(401);
        }
        $seo_lists = Seometa::onlyTrashed()->findOrFail($id);
        $seo_lists->restore();

        return redirect()->route('admin.seo.index');
    }

    /**
     * Permanently delete Listing from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('seometa_delete')) {
            return abort(401);
        }
        $seo_lists = Seometa::onlyTrashed()->findOrFail($id);
        $seo_lists->forceDelete();

        return redirect()->route('admin.seo.index');
    }

}
