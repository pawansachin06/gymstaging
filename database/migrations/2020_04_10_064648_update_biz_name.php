<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBizName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('label')->nullable()->after('name');
        });
        $business = \App\Models\Business::all();
        foreach ($business as $biz) {
            $label = ($biz->name != 'Physio') ? $biz->name: 'Physio / Chiropractor';
            $biz->update(['label' => $label]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('label');
        });
    }
}
