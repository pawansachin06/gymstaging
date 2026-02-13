<?php

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\Amenity;

class CategoriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                \App\Models\Category::create(['business_id' => $i, 'name' => "Biz {$i} Category {$j}"]);
            }
        }
    }
}
