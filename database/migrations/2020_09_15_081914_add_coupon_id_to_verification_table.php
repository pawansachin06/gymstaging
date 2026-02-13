<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponIdToVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verifications', function (Blueprint $table) {
            $table->string('coupon_id')->nullable();
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('count');
            $table->tinyInteger('redemptions')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verifications', function (Blueprint $table) {
            $table->dropColumn('coupon_id');
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('redemptions');
            $table->tinyInteger('count')->default(0)->nullable();
        });
    }
}
