<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\Amenity;

class AmenitiesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $items = [
            ['business_id' => 3, 'name' => 'Sports Massage'],
            ['business_id' => 3, 'name' => 'Treatment Plans'],
            ['business_id' => 3, 'name' => 'Posture Correction'],
            ['business_id' => 3, 'name' => 'Injury Rehab'],
            ['business_id' => 3, 'name' => 'Movement Analysis'],
            ['business_id' => 3, 'name' => 'Cupping Therapy'],
            ['business_id' => 3, 'name' => 'Kinesiology Taping'],
            ['business_id' => 3, 'name' => 'Video Analysis'],
            ['business_id' => 3, 'name' => 'Tens Machine'],
            ['business_id' => 3, 'name' => 'Training Plans'],
            ['business_id' => 3, 'name' => 'Accupuncture'],
            ['business_id' => 3, 'name' => 'Workshops'],

            ['business_id' => 2, 'name' => '1-1 Coaching'],
            ['business_id' => 2, 'name' => 'Training Plans'],
            ['business_id' => 2, 'name' => 'Competition Prep'],
            ['business_id' => 2, 'name' => 'Group Training'],
            ['business_id' => 2, 'name' => 'Diet Plans'],
            ['business_id' => 2, 'name' => 'Workshops'],
            ['business_id' => 2, 'name' => 'Bootcamps'],
            ['business_id' => 2, 'name' => 'Body Tracking'],
            ['business_id' => 2, 'name' => 'Goal Setting'],
            ['business_id' => 2, 'name' => 'Online Coaching'],
            ['business_id' => 2, 'name' => 'Fitness Testing'],

            ['business_id' => 1, 'name' => '24 Hour Gym'],
            ['business_id' => 1, 'name' => 'Lockers'],
            ['business_id' => 1, 'name' => 'Spinning Bikes'],
            ['business_id' => 1, 'name' => 'Free weights'],
            ['business_id' => 1, 'name' => 'Olympic platform'],
            ['business_id' => 1, 'name' => 'Football Pitch'],
            ['business_id' => 1, 'name' => 'Cardio machines'],
            ['business_id' => 1, 'name' => 'Punch bags'],
            ['business_id' => 1, 'name' => 'Toilets'],
            ['business_id' => 1, 'name' => 'Resistance machines'],
            ['business_id' => 1, 'name' => 'Creche'],
            ['business_id' => 1, 'name' => 'Changing rooms'],
            ['business_id' => 1, 'name' => 'Functional area'],
            ['business_id' => 1, 'name' => 'Tennis court'],
            ['business_id' => 1, 'name' => 'Showers'],
            ['business_id' => 1, 'name' => 'Classes'],
            ['business_id' => 1, 'name' => 'Squash court'],
            ['business_id' => 1, 'name' => 'Pool'],
            ['business_id' => 1, 'name' => 'Wifi'],
            ['business_id' => 1, 'name' => 'Badminton court'],
            ['business_id' => 1, 'name' => 'Jacuzzi'],
            ['business_id' => 1, 'name' => 'Parking'],
            ['business_id' => 1, 'name' => 'Pole studio'],
            ['business_id' => 1, 'name' => 'Steam room'],
            ['business_id' => 1, 'name' => 'Physios'],
            ['business_id' => 1, 'name' => 'Boxing Ring'],
            ['business_id' => 1, 'name' => 'sauna'],
            ['business_id' => 1, 'name' => 'Trainers'],
            ['business_id' => 1, 'name' => 'UFC/MMA Cage'],
            ['business_id' => 1, 'name' => 'cafe'],
            ['business_id' => 1, 'name' => 'Air conditioning'],
            ['business_id' => 1, 'name' => 'Track'],
            ['business_id' => 1, 'name' => 'Disables access'],
           
        ];
        foreach ($items as $item) {
            Amenity::firstOrCreate($item);
        }
       
    }
}
