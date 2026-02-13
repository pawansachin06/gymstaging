<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->integer('subscription_id')->unsigned();
            $table->foreign('subscription_id')->references('id')->on('subscriptions');

            $table->dateTime('date');
            $table->decimal('amount');
            $table->string('stripe_invoice_id');
            $table->string('stripe_charge_id')->nullable();
            $table->longText('meta')->nullable();

            $table->index(['deleted_at']);
        });

        Schema::table('listings', function($table) {
            if (!Schema::hasColumn('listings', 'user_id')) {
                $table->integer('user_id')->unsigned();
//                $table->foreign('user_id', 'fk_listing_to_user')->references('id')->on('users');
            }
        });

        Schema::create('listing_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'fk_review_to_user')->references('id')->on('users');

            $table->integer('listing_id')->unsigned();
            $table->foreign('listing_id', 'fk_review_to_listing')->references('id')->on('listings');

            $table->string('title');
            $table->longText('message')->nullable();
            $table->tinyInteger('rating')->default(0);

            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');

        Schema::table('listings', function($table) {
            if (Schema::hasColumn('listings', 'user_id')) {
//                $table->dropForeign('fk_listing_to_user');
                $table->dropColumn('user_id');
            }
        });

        Schema::dropIfExists('listing_reviews');
    }
}
