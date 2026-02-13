<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);
        $this->call(BusinessSeed::class);
        $this->call(CategoriesSeed::class);
        $this->call(CitySeed::class);
        $this->call(PlansSeed::class);
        $this->call(AmenitiesSeed::class);
        $this->call(CMSSeed::class);
//        $this->call(ListingSeed::class);

    }
}
