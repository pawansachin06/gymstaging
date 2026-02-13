<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertOfferPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = \App\Models\Setting::whereName('ORGANIZATION')->first();
        if($setting) {
            $value = $setting->value;
            if (!@$value['VERIFICATION_PRICE']) {
                $value['VERIFICATION_PRICE'] = 50;
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
        //
    }
}
