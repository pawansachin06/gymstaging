<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FeatureSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'name' => '24 Hour Gym'],
            ['id' => 2, 'name' => 'Free weights'],
            ['id' => 3, 'name' => 'Cardio machines'],
            ['id' => 4, 'name' => 'Resistance machines'],
            ['id' => 5, 'name' => 'Functional area'],
            ['id' => 6, 'name' => 'Classes'],
            ['id' => 7, 'name' => 'Wifi'],
            ['id' => 8, 'name' => 'Parking'],
            ['id' => 9, 'name' => 'Physios'],
            ['id' => 10, 'name' => 'Trainers'],
            ['id' => 11, 'name' => 'Air conditioning'],
            ['id' => 12, 'name' => 'Lockers'],
            ['id' => 13, 'name' => 'Olympic platform'],
            ['id' => 14, 'name' => 'Punch bags'],
            ['id' => 15, 'name' => 'Creche'],
            ['id' => 16, 'name' => 'Tennis court'],
            ['id' => 17, 'name' => 'Squash court'],
            ['id' => 18, 'name' => 'Badminton court'],
            ['id' => 19, 'name' => 'Pole studio'],
            ['id' => 20, 'name' => 'Boxing Ring'],
            ['id' => 21, 'name' => 'UFC/MMA Cage'],
            ['id' => 22, 'name' => 'Track'],
            ['id' => 23, 'name' => 'Spinning Bikes'],
            ['id' => 24, 'name' => 'Football Pitch'],
            ['id' => 25, 'name' => 'Toilets'],
            ['id' => 26, 'name' => 'Changing rooms'],
            ['id' => 27, 'name' => 'Showers'],
            ['id' => 28, 'name' => 'Pool'],
            ['id' => 29, 'name' => 'Jacuzzi'],
            ['id' => 30, 'name' => 'Steam room'],
            ['id' => 31, 'name' => 'sauna'],
            ['id' => 32, 'name' => 'cafe'],
            ['id' => 33, 'name' => 'Disables access'],
        ];

        foreach ($items as $item) {
            \App\Models\Feature::create($item);
        }
    }
}
