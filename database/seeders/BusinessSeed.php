<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BusinessSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'name' => 'Gym', 'icon' => 'fa fa-dumbbell'],
            ['id' => 2, 'name' => 'Coach', 'icon' => 'fa fa-scissors'],
            ['id' => 3, 'name' => 'Physio', 'icon' => 'fa fa-user-md'],
        ];

        foreach ($items as $item) {
            \App\Models\Business::create($item);
        }
    }
}
