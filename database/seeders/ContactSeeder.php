<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 5; $i++) {
            DB::table('contacts')->insert([
                [
                    'name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'phone' => $faker->e164PhoneNumber,
                    'date_birth' => $faker->dateTimeBetween('1995-01-01', '2000-12-31'),
                    'address' => $faker->address
                ]
            ]);
        }
    }
}
