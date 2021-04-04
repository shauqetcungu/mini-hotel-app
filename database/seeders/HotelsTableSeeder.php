<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Faker\Factory;
use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $categories=array("hotel","alternative","hostel","lodge","resort","guest-house");

        for($i = 0; $i < 20; $i++) {
            $random_keys=array_rand($categories,1);
            Hotel::create([
                "name" =>
                    $faker->word($maxLength = 10),
                "rating" =>
                    $faker->numberBetween($min = 1, $max = 5),
                "category" =>
                    $categories[$random_keys],
                "image" =>
                    $faker->imageUrl($width = 640, $height = 480),
                "reputation" =>
                    $faker->numberBetween($min = 1, $max = 1000),
                "price" =>
                    $faker->numberBetween($min = 1, $max = 1000),
                "availability" =>
                    $faker->numberBetween($min = 1, $max = 10),
                "location_id" =>
                    $faker->numberBetween($min = 1, $max = 13),
                "create_user_id" => 1,
                "created_at" => now()
            ]);
        };
    }
}
