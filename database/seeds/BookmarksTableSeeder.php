<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookmarksTableSeeder extends Seeder
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
            DB::table('bookmarks')->insert([
                'user_id' => rand(1,20),
                'bookmarkable_id' => rand(1,20),
                'bookmarkable_type' => $types[rand(0, 1)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
