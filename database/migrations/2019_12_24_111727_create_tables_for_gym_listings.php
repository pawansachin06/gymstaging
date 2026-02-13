<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForGymListings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->renameColumn('description', 'about');
            $table->string('timetable')->nullable();
            $table->integer('business_id');
        });

        if(! Schema::hasTable('listing_addresses')) {
            Schema::create('listing_addresses', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('name');
                $table->string('street');
                $table->string('city', 50);
                $table->string('country', 50);
                $table->string('postcode', 10);
                $table->string('latitude', 50)->nullable();
                $table->string('longitude', 50)->nullable();
                $table->string('based_gym')->nullable();

                $table->index(['deleted_at']);
            });
        }

        if(! Schema::hasTable('listing_links')) {
            Schema::create('listing_links', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('website')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('instagram')->nullable();

                $table->index(['deleted_at']);
            });
        }

        if(! Schema::hasTable('amenities')) {
            Schema::create('amenities', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('name');
                $table->integer('business_id')->unsigned()->nullable();

                $table->foreign('business_id')->references('id')->on('businesses');
                $table->index(['deleted_at']);
            });
        }

        if(! Schema::hasTable('amenity_listing')) {
            Schema::create('amenity_listing', function (Blueprint $table) {
                $table->integer('amenity_id')->unsigned()->nullable();
                $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('cascade');
                $table->integer('listing_id')->unsigned()->nullable();
                $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            });
        }

        if(! Schema::hasTable('listing_medias')) {
            Schema::create('listing_medias', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('file_path');

                $table->index(['deleted_at']);
            });
        }

        if(! Schema::hasTable('listing_qualifications')) {
            Schema::create('listing_qualifications', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('name');

                $table->index(['deleted_at']);
            });
        }

        if(! Schema::hasTable('listing_memberships')) {
            Schema::create('listing_memberships', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->decimal('price', 10, 2);
            });
        }

        if(! Schema::hasTable('listing_teams')) {
            Schema::create('listing_teams', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('name');
                $table->string('job')->nullable();
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users');

                $table->index(['deleted_at']);
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
        Schema::table('listings', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->renameColumn('about', 'description');
            $table->dropColumn(['timetable', 'business_id', 'profile_image', 'cover_image']);
        });

        Schema::dropIfExists('listing_addresses');
        Schema::dropIfExists('listing_links');
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('amenity_listing');
        Schema::dropIfExists('listing_medias');
        Schema::dropIfExists('listing_qualifications');
        Schema::dropIfExists('listing_memberships');
    }
}
