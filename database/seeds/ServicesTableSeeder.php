<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');

        for ($i = 0; $i < 100; $i ++) {
            DB::table('services')->insert([
                'name' => str_random(20),
                'description' => $faker->catchPhrase,
                'price' => 'from ' . rand(1, 10) . '0000vnd to ' . rand(11, 99) . '0000vnd',
                'garage_id' => rand(1, 20),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
