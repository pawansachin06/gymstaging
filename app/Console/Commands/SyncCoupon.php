<?php

namespace App\Console\Commands;

use App\Http\Helpers\StripeHelper;
use Illuminate\Console\Command;
use App\Models\Coupon;
use \Carbon\Carbon;

class SyncCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:coupon {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Stripe Coupon';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = Coupon::query();

        if ($id = $this->argument('id')) {
            $query->where('id', $id);
        }

        $coupons = $query->get();

        $stripe = new StripeHelper();

        foreach ($coupons as $coupon) {
            try {
                if (!$coupon->stripe_id) {
                    //create coupon
                    $data = [
                        'duration' => $coupon->duration,
                        'name' => $coupon->code,
                        'currency' => env('CASHIER_CURRENCY')
                    ];
                    if($coupon->duration_months){
                        $data['duration_in_months'] = $coupon->duration_months;
                    }

                    if($expire = $coupon->expires_at){
                        $data['redeem_by'] = Carbon::parse($expire)->timestamp;
                    }

                    if($redemp = $coupon->max_redemptions){
                        $data['max_redemptions'] = $redemp;
                    }

                    if ($coupon->type == 1) {
                        $data['percent_off'] = $coupon->value;
                    } elseif ($coupon->type == 2) {
                        $data['amount_off'] = (float)$coupon->value * 100;
                    }

                    $stripe = $stripe->createCoupon($data);

                    if ($stripe) {
                        $coupon->stripe_id = $stripe->id;
                        $coupon->save();
                    }
                } else {
                    //update coupon
                    $stripe = $stripe->updateCoupon($coupon->stripe_id, [
                        'name' => $coupon->code
                    ]);
                }
            } catch (\Exception $e) {
                //
            }
        }
    }
}
