<?php

namespace App\Models;

use App\Traits\UuidTrait;
use App\Traits\StaticTableName;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CheckoutSession extends Model
{
    use UuidTrait, StaticTableName;

    protected $fillable = [
        'name', 'email', 'type', 'status', 'coupon_code', 'amount',
        'currency_code', 'user_id', 'membership_id',
        'stripe_price_id', 'stripe_product_id', 'stripe_customer_id',
        'stripe_subscription_id', 'password', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public static function createTable()
    {
        $messages = [];
        $tableName = self::getTableName();
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 100);
                $table->string('email', 100);
                $table->string('type', 50);
                $table->string('status', 32);
                $table->string('coupon_code', 100)->nullable();
                $table->decimal('amount', 10, 2);
                $table->string('currency_code', 3);
                $table->uuid('user_id')->nullable();
                $table->uuid('membership_id')->nullable();
                $table->string('stripe_price_id')->nullable();
                $table->string('stripe_product_id')->nullable();
                $table->string('stripe_customer_id')->nullable();
                $table->string('stripe_subscription_id')->nullable();
                $table->string('password')->nullable();
                $table->json('meta');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
            $messages[] = "$tableName created";
        }
        return $messages;
    }
}
