<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['App\Models\Article', 'App\Models\Garage'];
        for ($i = 0; $i < 1000; $i ++) {
            DB::table('comments')->insert([
                'user_id' => rand(1,20),
                'commentable_id' => rand(1,20),
                'commentable_type' => $types[rand(0, 1)],
                'content' => str_random(30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
