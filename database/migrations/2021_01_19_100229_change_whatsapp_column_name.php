<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeWhatsappColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listing_links', function (Blueprint $table) {
            $table->renameColumn('whatapp', 'whatsapp');
            $table->string('whatsapp_code', 5)->nullable()->default(44)->after('listing_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listing_links', function (Blueprint $table) {
            $table->renameColumn('whatsapp', 'whatapp');
            $table->dropColumn('whatsapp_code');
        });
    }
}
