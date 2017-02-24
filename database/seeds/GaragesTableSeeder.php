<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\AdministrationUnit;
class GaragesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = AdministrationUnit::where('parent_id', 1)->get()->toArray();
        for ($i = 0; $i < 1000; $i ++) {
            $distIdx = array_rand($districts);
            $dist = $districts[$distIdx];
            $distId = $dist['id'];
            $wards = AdministrationUnit::where('parent_id', $distId)->get()->toArray();
            if (sizeof($wards) === 0) {
                $wardId = null;
            }
            else {
                $wardIdx = array_rand($wards);
                $ward = $wards[$wardIdx];
                $wardId = $ward['id'];
            }

            $tmpLat = 21.0072975;
            $tmpLng = 105.8015291;

            $addLat = rand(1000, 999999)/10000000;
            $addLng = rand(1000, 999999)/10000000;
            $lats = [$tmpLat + $addLat, $tmpLat - $addLat];
            $lngs = [$tmpLng + $addLng, $tmpLng - $addLng];
            $lat = $lats[rand(0,1)];
            $lng = $lngs[rand(0,1)];
            DB::table('garages')->insert([
                'lat' => $lat,
                'lng' => $lng,
                'name' => str_random(20),
                'short_description' => str_random(100),
                'description' => str_random(1000),
                'phone_number' => '' . rand(100, 999) . '' . rand(100, 999) . '' . rand(100, 999),
                'address' => str_random(30),
                'website' => "http://" . str_random(10) . '.com.vn',
                'province_id' => 1,
                'district_id' => $distId,
                'ward_id' => $wardId,
                'user_id' => rand(1, 20),
                'working_time' => 'from ' . rand(7,8) . 'AM to ' . rand(16, 22) . 'PM',
                'rating' => 3.5,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
