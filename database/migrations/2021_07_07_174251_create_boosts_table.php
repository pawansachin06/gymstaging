<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boosts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('user_id');
            $table->integer('listing_id')->unsigned();
            $table->string('payment_id')->nullable();
            $table->text('brand')->nullable();
            $table->longText('message')->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comments('0->Pending,1->Approved,2->Rejected');
        });

        $setting = \App\Models\Setting::whereName('ORGANIZATION')->first();
        if($setting) {
            $value = $setting->value;
            if (!@$value['BOOST_PRICE']) {
                $value['BOOST_PRICE'] = 50;
            }
            $setting->updateSetting('ORGANIZATION',$value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boosts');
    }
}
