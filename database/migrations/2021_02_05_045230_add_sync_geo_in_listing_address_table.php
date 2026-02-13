<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyncGeoInListingAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listing_addresses', function (Blueprint $table) {
            $table->boolean('sync_geo')->default(1)->nullable();
            $table->tinyInteger('sync_geo_failed')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listing_addresses', function (Blueprint $table) {
            $table->dropColumn(['sync_geo', 'sync_geo_failed']);
        });
    }
}
