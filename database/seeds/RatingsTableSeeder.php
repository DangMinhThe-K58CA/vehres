<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1000; $i ++) {
            DB::table('ratings')->insert([
                'user_id' => rand(1,20),
                'garage_id' => rand(1,20),
                'score' => rand(1,10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
