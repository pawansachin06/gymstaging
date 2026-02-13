<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Auth;

class ProductOrderController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('product_order_management_access')) {
            return abort(401);
        }
        $status = request('is_completed') ?  request('is_completed') : 0;
        $productOrders = ProductOrder::orderBy('created_at', 'DESC')->where('is_completed', $status)->get();

        return view('admin.product_orders.index', compact('productOrders'));
    }
    public function show($id)
    {
        if (! Gate::allows('product_order_management_view')) {
            return abort(401);
        }
        $productOrder = ProductOrder::findOrFail($id);

        return view('admin.product_orders.show', compact('productOrder'));
    }
    public function markAsCompleted($id)
    {
        if (! Gate::allows('product_order_management_view')) {
            return abort(401);
        }
        $productOrder = ProductOrder::findOrFail($id);
        $productOrder->is_completed = true;
        $productOrder->save();
        alert()->success('Order has been marked as completed successfully');

        return redirect()->route('admin.product_order.index');
    }
}