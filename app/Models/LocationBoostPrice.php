<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class LocationBoostPrice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'postcode',
        'description',
        'amount',
        'currency_code',
        'status',
        'environment',
        'stripe_product_id',
        'stripe_price_id',
        'meta',
    ];

    protected $casts = [
        'amount' => 'float',
        'meta' => 'array',
    ];

    public function isLive()
    {
        return $this->environment !== 'sandbox';
    }

    public static function createTable()
    {
        $messages = [];
        $tableName = 'location_boost_prices';
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('postcode', 16)->nullable();
                $table->string('description')->nullable();
                $table->decimal('amount');
                $table->string('currency_code', 5);
                $table->enum('status', ['active', 'inactive']);
                $table->string('environment', 10);
                $table->string('stripe_product_id')->nullable();
                $table->string('stripe_price_id')->nullable();
                $table->json('meta')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });
            $messages[] = "$tableName created";
        }
        return $messages;
    }

    public static function defaultPrice($isLive = false)
    {
        $apiSecret = $isLive ?
            config('services.stripe.live.client_secret') :
            config('services.stripe.sandbox.client_secret');
        $stripe = new StripeClient(['api_key' => $apiSecret]);
        $environment = $isLive ? 'live' : 'sandbox';

        $item = LocationBoostPrice::query()
            ->whereNull('postcode')
            ->whereNotNull('stripe_price_id')
            ->where('environment', $environment)
            ->first();
        if (!$item) {
            $item = LocationBoostPrice::create([
                'amount' => 99,
                'status' => 'active',
                'currency_code' => 'GBP',
                'environment' => $environment,
                'name' => 'Location Boost Price',
                'description' => 'Price applied to all postcodes',
            ]);
            $product = $stripe->products->create([
                'name' => $item->name,
                'description' => $item->description,
            ]);
            Log::info('LocationBoostPrice', ['product' => $product]);
            $item->update(['stripe_product_id' => $product->id]);
            $price = $stripe->prices->create([
                'currency' => strtolower($item->currency_code),
                'unit_amount' => $item->amount * 100,
                'recurring' => ['interval' => 'month'],
                'product' => $product->id,
            ]);
            $item->update(['stripe_price_id' => $price->id]);
            Log::info('LocationBoostPrice', ['price' => $price]);
        }
    }
}
