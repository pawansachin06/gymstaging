<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('listing_id')->unsigned();
            $table->string('payment_id')->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comments('0->Pending,1->Approved,2->Rejected');
            $table->index('listing_id','verifications_listings_index');
        });

        Schema::rename('listing_verification_files', 'files_verifications');
        Schema::table('files_verifications', function (Blueprint $table) {
            $table->dropColumn(['id', 'listing_id']);
            $table->dropTimestamps();
            $table->dropSoftDeletes();
            $table->integer('verification_id')->unsigned()->nullable();
            $table->index('verification_id');
        });

        \App\Models\Listing::query()->update(['verified'=>\App\Models\Verification::PENDING]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification');

        Schema::rename('files_verifications', 'listing_verification_files');
        Schema::table('listing_verification_files', function (Blueprint $table) {
            $table->dropColumn('verification_id');
            $table->dropIndex('verifications_listings_index');

            $table->increments('id');
            $table->integer('listing_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
