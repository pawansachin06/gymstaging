<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationBoostPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_boost_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_name', 255);
            $table->text('description')->nullable();
            $table->string('stripe_plan_id', 255);
            $table->decimal('amount', 10, 2);
            $table->decimal('offer_amount', 10, 2);
            $table->integer('allowed_cities');
            $table->enum('is_bestseller', ['0', '1'])->nullable()->default('0');
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->softDeletes();
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
        Schema::dropIfExists('location_boost_plans');
    }
}
