<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\GettingGarageRequest;
use App\Repositories\Eloquent\GarageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Criteria\NearestGaragesCriteria;

class GarageController extends Controller
{

    const LENGTH_OF_DECIMAL_DEGREE = 111.32;

    private $garageRepository;
    
    public function __construct(GarageRepository $garageRepository)
    {
        $this->garageRepository = $garageRepository;
    }
    
    public function getGarages(GettingGarageRequest $request)
    {
        $curPos = $request->input('curPos');
        $options =  $request->input('options');
        $garages = [];

        if (array_key_exists('radius', $options)) {
            $rad = $options['radius'];
            $criteria = new NearestGaragesCriteria($curPos, $rad);
            $this->garageRepository->pushCriteria($criteria);

            $results = $this->garageRepository->all(['id', 'lat', 'lng','name', 'short_description', 'type','avatar']);
            
            foreach ($results as $garage) {
                if ($this->isNear($curPos, $garage, $rad)) {
                    array_push($garages, $garage);
                }
            }
        }

        $response = [
            'status' => 1,
            'data' => $garages,
        ];

        return \Response::json($response);
    }

    public function getSpecificGarage(Request $request)
    {
//        dd($request->input('id'));
    }

    /**
     * @param $curPos
     * @param $position
     * @param $rad km
     * @return bool
     */
    private function isNear($curPos, $position, $rad)
    {
        $curLat = $curPos['lat'];
        $curLng = $curPos['lng'];
        $R = 6371e3; // metres
        $x1 = deg2rad($curLat);
        $x2 = deg2rad($position->lat);
        $dx = deg2rad(($position->lat - $curLat));
        $dr = deg2rad(($position->lng - $curLng));
        $a = sin($dx/2) * sin($dx/2) +
            cos($x1) * cos($x2) *
            sin($dr/2) * sin($dr/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $R * $c;
        if ($distance <= $rad * 1000) {
            return true;
        } else {
            return false;
        }
    }
}
