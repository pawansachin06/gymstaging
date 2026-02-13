<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Productfaqs;
use App\Models\Couponproducts;
use App\Models\Couponproductrelation;

class ProductController extends Controller
{
   /**
     * Show the application products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data['products'] = Products::with(['productimages'])->get();

    	return view('mainTable.products',$data);
    }

    public function productDetails($product_id)
    {

    	$product_id = base64_decode($product_id);
        
    	$data['product_details'] = Products::where('id',$product_id)->with(['productfaqs','productimages'])->first();
        if($data['product_details']){
            return view('mainTable.product_details',$data);
        }else{
            return abort(404, 'Page not found.');
        }
    	
    }

    public function productOrderNow($product_id)
    {

    	$product_id = base64_decode($product_id);
    	$data['product_details'] = Products::where('id',$product_id)->with(['productfaqs','productimages'=> function ($query) {
            $query->first();
        }])->first();

        if($data['product_details']){
           return view('mainTable.product_order_now',$data);
        }else{
            return abort(404, 'Page not found.');
        }
    	
    }

    public function productApplyCouponCode(Request $request)
    {
        $send_response = [];
        $coupon_code = $request['discount_code'];
        $product_id  = $request['product_id'];
        $product_price  = $request['product_price'];

        //check coupon code is available and active
        $get_coupon  = Couponproducts::where('code',$coupon_code)->where('status',1)->first();
       
        if($get_coupon){
            if($get_coupon->maximum_redemptions > $get_coupon->coupon_used){
                //check coupon code is connected to product
                $get_coupon_product = Couponproductrelation::where('product_id',$product_id)->where('coupon_id',$get_coupon->id)->first();

                if($get_coupon_product){
                    $coupon_type = $get_coupon->type;
                    $coupon_value = $get_coupon->value;

                    //check coupon code type and apply coupon as per value and percentage on product price
                    if($coupon_type == 'Percentage'){ 
                        $discount_value = ($product_price * $coupon_value) / 100;
                        $final_discount = $product_price - $discount_value;
                        $send_response = ['code' => '1', 'message' => 'Coupon code applied successfully','product_price' => $product_price, 'discounted_price' => strval($discount_value),'new_price' => strval($final_discount)];
                    }else{
                        if($coupon_value > $product_price){
                            $send_response = ['code' => '1', 'message' => 'Coupon code applied successfully','product_price' => $product_price, 'discounted_price' => strval(number_format($product_price, 2)),'new_price' => '0.00'];
                        }else{
                            $final_discount = $product_price - $coupon_value;
                            $send_response = ['code' => '1', 'message' => 'Coupon code applied successfully','product_price' => $product_price, 'discounted_price' => strval($coupon_value),'new_price' => strval(number_format($final_discount, 2))];
                        }
                    }
                }else{
                    //coupon not connected to product
                    $send_response = ['code' => '0', 'message' => 'Coupon code is not valid for this product'];
                }
            }else{
                 //coupon not connected to product
                $send_response = ['code' => '0', 'message' => 'coupon code is used maximum redemptions times'];
            }
            
        }else{
            //invalid coupon
           $send_response = ['code' => '0', 'message' => 'Coupon code is not valid'];
        }

        return response()->json($send_response);
    }

}
