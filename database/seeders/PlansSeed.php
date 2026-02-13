<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlansSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Plan::create(['business_id' => 1, 'frequency' => "M", 'amount' => '30']);
        \App\Models\Plan::create(['business_id' => 1, 'frequency' => "Y", 'amount' => '300']);
        \App\Models\Plan::create(['business_id' => 2, 'frequency' => "M", 'amount' => '50']);
        \App\Models\Plan::create(['business_id' => 2, 'frequency' => "Y", 'amount' => '500']);
        \App\Models\Plan::create(['business_id' => 3, 'frequency' => "M", 'amount' => '70']);
        \App\Models\Plan::create(['business_id' => 3, 'frequency' => "Y", 'amount' => '700']);
    }
}
