<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('coupons');
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('code');
            $table->tinyInteger('type')->default(1)->comment('1 - Percentage, 2 - Flat Amount');
            $table->decimal('value',10,2)->comment('Percentage or Amount');
            $table->decimal('minprice',10,2)->default(0)->comment('Minimum price to allow coupons');
            $table->dateTime('expires_at')->nullable();
            $table->tinyInteger('user_redemptions')->default(1)->comment('0 - Unlimited');
            $table->tinyInteger('max_redemptions')->nullable()->comment('0 - Unlimited');
            $table->tinyInteger('status')->default(1)->comment('0 - Disabled, 1 - Enabled');
            $table->string('stripe_id')->nullable();
            $table->string('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
