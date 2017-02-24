<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1000; $i ++) {

            DB::table('articles')->insert([
                'user_id' => rand(1, 20),
                'title' => str_random(20),
                'type' => 1,
                'status' => 1,
                'short_description' => str_random(100),
                'content' => str_random(1000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
