<?php

namespace Database\Seeders;

use App\Models\Location;
use Faker;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Faker\Provider\Address;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        for($i = 0; $i < 20; $i++) {
            Location::create([
                "city" => $faker->city,
                "state" => $faker->state,
                "country" =>$faker->country,
                "zip_code" => Address::postcode(),
                "address" => $faker->streetAddress,
                "create_user_id" => 1,
                "created_at" => now()
            ]);
        }
//        Location::insert([
//            [
//                "city" => "Podgorica",
//                "state" => "Montenegro",
//                "country" => "Montenegro",
//                "zip_code" => "81000",
//                "address" => "Njegoseva",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Phoenix",
//                "state" => "Arizona",
//                "country" => "USA",
//                "zip_code" => "81000",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Atlanta",
//                "state" => "Georgia",
//                "country" => "USA",
//                "zip_code" => "81000",
//                "address" => "Second street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Denver",
//                "state" => "Colorado",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "Third street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Columbus",
//                "state" => "Ohio",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Indianapolis",
//                "state" => "Indiana",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Jackson",
//                "state" => "Mississippi",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Austin",
//                "state" => "Texas",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Salem",
//                "state" => "Oregon",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Sacramento",
//                "state" => "California",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Albany",
//                "state" => "New York",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Salt Lake City",
//                "state" => "Utah",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//            [
//                "city" => "Nashville",
//                "state" => "Tennessee",
//                "country" => "USA",
//                "zip_code" => "81111",
//                "address" => "First street",
//                "create_user_id" => 1,
//                "created_at" => now()
//            ],
//        ]);
    }
}
