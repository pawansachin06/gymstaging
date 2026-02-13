<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFaqsRequest;
use App\Http\Requests\Admin\UpdateFaqsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Auth;
use App\Models\ReportAbuse;

class FaqController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a coupon of Coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if (! Gate::allows('faq_access')) {
            return abort(401);
        }

        $faqs = Faq::all();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating new Coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('faq_create')) {
            return abort(401);
        }
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created Coupon in storage.
     *
     * @param  \App\Http\Requests\StoreListsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFaqsRequest $request)
    {
        if (! Gate::allows('faq_create')) {
            return abort(401);
        }
        $faq = new Faq();
        $faq->fill($request->except('_token'));
        $faq->save();
       
        return redirect()->route('admin.faq.index');
    }


    /**
     * Show the form for editing Coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('faq_edit')) {
            return abort(401);
        }
        
        $faq = Faq::findOrFail($id);

        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update Coupon in storage.
     *
     * @param  \App\Http\Requests\UpdateListsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFaqsRequest $request, $id)
    {
        if (! Gate::allows('faq_edit')) {
            return abort(401);
        }
        $faq = Faq::findOrFail($id);
        $faq->fill([
            'question' => $request->question,
            'status' => $request->status,
            'answer' => $request->answer
        ]);
        $faq->save();  

        return redirect()->route('admin.faq.index');
    }


    /**
     * Display Coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove Coupon from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('faq_delete')) {
            return abort(401);
        }
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index');
    }
    /**
     * Delete all selected Coupon at once.
     *
     * @param Request $request
     */

    /**
     * Restore Coupon from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * Permanently delete Coupon from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
