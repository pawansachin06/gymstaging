<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Web\CreateProductOrder;
use Stripe\StripeClient;
use App\Models\Products;
use App\Models\Couponproducts;
use App\Models\Couponproductrelation;
use App\Models\ProductOrder;
use App\Models\TempProductOrder;
use Illuminate\Support\Str;
use App\Mail\ProductOrderConfirmationToCustomer;
use DB;
use Mail;

class ProductOrderController extends Controller
{
	public function createProductOrder(CreateProductOrder $request, $productId)
	{
		DB::beginTransaction();
		$product = Products::where('id', $productId)->first();
		if (empty($product)) {
			alert()->error('Product not found');

			return redirect()->back();
		}
		$productPrice = $product->price;
		if (!empty($request->discount_code) && $request->is_coupon_applied == 1) {
			$coupon_code = $request->discount_code;
			$get_coupon  = Couponproducts::where('code', $coupon_code)->where('status', 1)->first();
			if (!empty($get_coupon)) {
				if($get_coupon->maximum_redemptions > $get_coupon->coupon_used) {
					$get_coupon_product = Couponproductrelation::where('product_id', $product->id)->where('coupon_id', $get_coupon->id)->first();
					if(!empty($get_coupon_product)) {
						$coupon_type = $get_coupon->type;
                    	$coupon_value = $get_coupon->value;
                    	if($coupon_type == 'Percentage') {
                    		$discount_value = ($product->price * $coupon_value) / 100;
                        	$productPrice = $product->price - $discount_value;
                        	$productPrice = number_format($productPrice, 2);
                        	$couponId = $get_coupon->id;
                    	} else {
                    		if($coupon_value > $product->price) {

							} else {
								$discount_value = $coupon_value;
								$productPrice = $product->price - $coupon_value;
								$productPrice = number_format($productPrice, 2);
								$couponId = $get_coupon->id;
							}
                    	}
					}
				}
			}
		}
		$referenceId = Str::uuid()->toString();
		$stripe = new StripeClient(config('stripe.secret'));
		try {
			$stripePayment = $stripe->paymentIntents->create([
			  'return_url' => route('product.order.stripe3dResponse', ['reference_id' => $referenceId]),
			  'amount' => $productPrice * 100,
		      'payment_method_types' => ['card'],
		      'currency' => config('stripe.currency'),
		      'payment_method' => $request->payment_method_id,
		      'confirm' => true
			]);
			if (isset($stripePayment->next_action) && isset($stripePayment->next_action->redirect_to_url->url)) {
				if($stripePayment->next_action->type == 'redirect_to_url') {
					$tempProductOrderData = [
						'reference_id' => $referenceId,
						'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
						'product_id' => $product->id,
						'product_coupon_id' => isset($couponId) ? $couponId : null,
						'product_details' => json_encode($product->toArray(), 1),
						'coupon_details' => isset($couponId) ? json_encode($get_coupon->toArray(), 1) : null,
						'customer_name' => $request->name,
						'customer_email' => $request->email,
						'actual_price' => $product->price,
						'discount' => isset($discount_value) ? $discount_value : null,
						'net_price' => $productPrice,
						'stripe_payment_id' => $stripePayment->id,
					];
					TempProductOrder::create($tempProductOrderData);
					DB::commit();

					return redirect()->to($stripePayment->next_action->redirect_to_url->url);
				}
			}
			$productOrder = [
				'reference_id' => $referenceId,
				'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
				'product_id' => $product->id,
				'product_coupon_id' => isset($couponId) ? $couponId : null,
				'product_details' => json_encode($product->toArray(), 1),
				'coupon_details' => isset($couponId) ? json_encode($get_coupon->toArray(), 1) : null,
				'customer_name' => $request->name,
				'customer_email' => $request->email,
				'actual_price' => $product->price,
				'discount' => isset($discount_value) ? $discount_value : null,
				'net_price' => $productPrice,
				'stripe_payment_id' => $stripePayment->id,
			];
			$productOrder = ProductOrder::create($productOrder);
			if (!empty($productOrder->product_coupon_id)) {
				Couponproducts::where('id', $productOrder->product_coupon_id)->increment('coupon_used', 1);
			}
			DB::commit();
			alert()->success('Thank you for your order, We will update you as soon as possible');

			return redirect()->route('home');
		} catch (Exception $e) {
		}
	}
	public function stripe3dResponse($referenceId)
	{
		DB::beginTransaction();
		$tempProductOrder = TempProductOrder::where('reference_id', $referenceId)->first();
		if (empty($tempProductOrder)) {
			alert()->error('Your payment has been taken but not able to generate order, please contact admin for refund');

			return redirect()->route('home');
		}
		$stripe = new StripeClient(config('stripe.secret'));
		$checkPaymentStatus = $stripe->paymentIntents->retrieve($tempProductOrder->stripe_payment_id, []);
		if ($checkPaymentStatus->status != 'succeeded') {
			$product = json_decode($tempProductOrder->product_details);
			alert()->error('You have declined the payment');

			return redirect()->route('product.order_now', ['product_id' => base64_encode($product->id)]);
		}
		$productOrderData = [
			'reference_id' => $referenceId,
			'user_id' => $tempProductOrder->user_id,
			'product_id' => $tempProductOrder->product_id,
			'product_coupon_id' => $tempProductOrder->product_coupon_id,
			'product_details' => $tempProductOrder->product_details,
			'coupon_details' => $tempProductOrder->coupon_details,
			'customer_name' => $tempProductOrder->customer_name,
			'customer_email' => $tempProductOrder->customer_email,
			'actual_price' => $tempProductOrder->actual_price,
			'discount' => $tempProductOrder->discount,
			'net_price' => $tempProductOrder->net_price,
			'stripe_payment_id' => $tempProductOrder->stripe_payment_id
		];
		$productOrder = ProductOrder::create($productOrderData);
		if (!empty($tempProductOrder->product_coupon_id)) {
			Couponproducts::where('id', $tempProductOrder->product_coupon_id)->increment('coupon_used', 1);
		}
		$tempProductOrder->delete();
		DB::commit();
		alert()->success('Thank you for your order, We will update you as soon as possible');

		return redirect()->route('home');
	}
}