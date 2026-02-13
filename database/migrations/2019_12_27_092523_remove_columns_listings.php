<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnsListings extends Migration
{
    private $listing_tables = ['listing_addresses' , 'listing_medias' ,'listing_links' , 'listing_teams' , 'listing_memberships', 'listing_qualifications' ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function($table) {
            if (Schema::hasColumn('listings', 'city_id')) {
                $table->dropForeign('91033_5a12afe2de7f3');
                $table->dropColumn('city_id');
            }
        });

        foreach($this->listing_tables as $table_name){
            Schema::table($table_name, function($table) use($table_name) {
                if (!Schema::hasColumn($table_name, 'listing_id')) {
                    $table->integer('listing_id');

                }
            });
        }
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
