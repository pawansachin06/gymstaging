<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('customer_name', 50)->nullable();
            $table->string('customer_email', 50)->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('product_coupon_id')->nullable();
            $table->longText('product_details')->nullable();
            $table->longText('coupon_details')->nullable();
            $table->string('actual_price', 50)->nullable();
            $table->string('discount', 50)->nullable();
            $table->string('net_price', 50)->nullable();
            $table->string('stripe_payment_id', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_orders');
    }
}
