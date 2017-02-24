<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1000; $i ++) {
            $types = ['App\Models\Article', 'App\Models\Garage'];
            DB::table('visits')->insert([
                'user_id' => rand(1,20),
                'visitable_id' => rand(1,20),
                'visitable_type' => $types[rand(0, 1)],
                'is_latest' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        
        /**
         * Update an latest visit.
         */
        $distinct = DB::select('SELECT MAX(id) as id FROM visits GROUP BY CONCAT(user_id, \'-\', visitable_id, \'-\', visitable_type)');
        foreach ($distinct as $v) {
            DB::table('visits')->where('id',$v->id)->update([
                'is_latest' => 1,
                'created_at' => Carbon::now()->addDay(1),
                'updated_at' => Carbon::now()->addDay(1),
            ]);
        }
    }
}
