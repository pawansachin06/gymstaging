<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1511173734CompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('listings')) {
            Schema::create('listings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('city_id')->nullable();
                $table->string('businesses')->nullable();
                $table->string('address')->nullable();
                $table->text('description')->nullable();

                $table->timestamps();
                $table->softDeletes();

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
        Schema::dropIfExists('listings');
    }
}
