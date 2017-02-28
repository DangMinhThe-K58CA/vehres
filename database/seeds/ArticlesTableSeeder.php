<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');
        for ($i = 0; $i < 1000; $i ++) {

            DB::table('articles')->insert([
                'user_id' => rand(1, 20),
                'title' => $faker->catchPhrase,
                'type' => 1,
                'status' => 1,
                'short_description' => $faker->catchPhrase,
                'content' => $faker->paragraph,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
