<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableToAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listing_addresses', function (Blueprint $table) {       
            $table->string('name')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('city', 50)->nullable()->change();
            $table->string('country', 50)->nullable()->change();
            $table->string('postcode', 10)->nullable()->change();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
