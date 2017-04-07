<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\AdministrationUnit;
use Faker\Factory as Faker;

class GaragesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');
        $districts = AdministrationUnit::where('parent_id', 1)->get()->toArray();

        for ($i = 0; $i < 1000; $i ++) {
            $partners = DB::table('users')->select('id')->where('role', 2)->get()->toArray();
            $partnerIds = [];
            foreach ($partners as $partner) {
                array_push($partnerIds, $partner->id);
            }

            $randPartnerIdx = array_rand($partnerIds);
            $randPartnerId = $partnerIds[$randPartnerIdx];

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
                'name' => 'Tiệm sửa xe ' . $faker->company,
                'short_description' => $faker->catchPhrase,
                'description' => $faker->paragraph,
                'phone_number' => $faker->tollFreePhoneNumber,
                'address' => $faker->address,
                'website' => "http://" . str_random(10) . '.com.vn',
                'province_id' => 1,
                'district_id' => $distId,
                'ward_id' => $wardId,
                'user_id' => $randPartnerId,
                'working_time' => 'from ' . rand(7,8) . 'AM to ' . rand(16, 22) . 'PM',
                'rating' => 3.5,
                'status' => 1,
                'type' => rand(1,3),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
