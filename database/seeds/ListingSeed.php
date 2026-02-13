<?php

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\City;

class ListingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for($i = 0; $i < 1; $i++) {

            $business_id = rand(1, 3);
            $listing = App\Models\Listing::create([
                'name' => $faker->company,
                'about' => $faker->text($maxNbChars = 400) ,
                'business_id' => 1,
                'category_id' => \App\Models\Category::where('business_id', $business_id)->inRandomOrder()->first()->value('id'),
                'user_id' => 2,
                'published' => 1,
                'profile_image'=>'1578568350-images.jpeg',
                'cover_image' =>'1578493489-download.jpeg',
                'timetable' => 'dummy.pdf',
                'timings' => '["ALL"]',
                'signup_url' => 'https://www.google.co.in/',
                'title' => $faker->company,
                'keyword' => $faker->company,
                'description' => $faker->text($maxNbChars = 400),
                'slug'   =>  'gym-'.$i 
            ]);

            App\Models\ListingAddress::create([
                'name' => $faker->company,                
                'street' => $faker->address,
                'city' => $faker->city,
                'country' => $faker->country,
                'postcode' => $faker->postcode,
                'listing_id' => $listing->id,
                'latitude' => 51.5223233,
                'longitude' => -0.106107
            ]);

            App\Models\ListingLink::create([
                'email' => $faker->email,                
                'phone'  => 976757788,
                'website' => 'https://www.google.co.in/',
                'facebook' =>'https://www.google.co.in/',
                'twitter' => 'https://www.google.co.in/',
                'instagram' => 'https://www.google.co.in/',
                'listing_id' => $listing->id
            ]);

            App\Models\ListingMedia::create([
                'file_path' => '1578923620-gym-large1.jpg',               
                'listing_id' => $listing->id
            ]);

            App\Models\ListingMembership::create([
                'name' => 'Plan 1',
                'price' => '250',
                'listing_id' => $listing->id
            ]);

            App\Models\ListingQualification::create([
                'name' => 'Level1 Trainer',               
                'listing_id' => $listing->id
            ]);

            App\Models\ListingResult::create([
                'file_path' => '1578923620-gym-large1.jpg',               
                'listing_id' => $listing->id
            ]);

            App\Models\ListingReview::create([
                'title' => 'Nice gym',    
                'message' => 'This is Nice gym', 
                'rating'  => 4,
                'user_id' => 2,
                'slug' =>   'gym-'.$i,        
                'listing_id' => $listing->id
            ]);

            App\Models\ListingTeam::create([
                'name' => 'John',    
                'job' => 'Trainer', 
                'user_id'  => 2,
                'file_path' =>   '1579591019-gym3.jpeg',        
                'listing_id' => $listing->id
            ]);




        }
    }
}
