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
            $partners = DB::table('users')->select('id')->where('role', 2)->get()->toArray();
            $partnerIds = [];
            foreach ($partners as $partner) {
                array_push($partnerIds, $partner->id);
            }

            $randPartnerIdx = array_rand($partnerIds);
            $randPartnerId = $partnerIds[$randPartnerIdx];

            DB::table('articles')->insert([
                'user_id' => $randPartnerId,
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
