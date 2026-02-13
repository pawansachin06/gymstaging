<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1511174113CompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            if (Schema::hasColumn('listings', 'city_id')) {
                $table->dropColumn('city_id');
            }
            if (Schema::hasColumn('listings', 'businesses')) {
                $table->dropColumn('businesses');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('city_id')->nullable();
            $table->string('businesses')->nullable();
        });

    }
}
