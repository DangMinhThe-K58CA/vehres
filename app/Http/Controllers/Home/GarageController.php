<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\GettingGarageRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\SpecificGarageRequest;
use App\Models\Rating;
use App\Repositories\Contracts\GarageRepositoryInterface;
use App\Repositories\Contracts\VisitRepositoryInterface;
use App\Repositories\Criteria\HomeGarageCriteria;
use App\Repositories\Eloquent\GarageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Criteria\WhereConditionCriteria;
use App\Repositories\Criteria\NearestGaragesCriteria;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class GarageController extends Controller
{

    const LENGTH_OF_DECIMAL_DEGREE = 111.32;

    private $response;
    private $garageRepository;
    
    public function __construct(GarageRepositoryInterface $garageRepository)
    {
        $this->response = [
            'status' => 1,
            'data' => [],
        ];

        $this->garageRepository = $garageRepository;
        $this->garageRepository->pushCriteria(new HomeGarageCriteria());
    }

    
    public function rate(RatingRequest $request)
    {
        $userId = Auth::user()->id;
        $garageId = $request->input('garage_id');
        $score = $request->input('score');

        $curRate = Rating::where('garage_id', $garageId)->where('user_id', $userId)->first();
        if ($curRate !== null) {
            $curRate->score = $score;
            $curRate->save();
        } else {
            $newRate = Rating::create([
                'user_id' => $userId,
                'garage_id' => $garageId,
                'score' => $score,
            ]);
        }

        $garage = $this->garageRepository->find($garageId);
        $newAvg = Rating::where('garage_id', $garageId)->avg('score');
        $garage->rating = $newAvg;
        $garage->save();

        return \Response::json(['status' => 1, 'data' => 'Thank for rating.']);
    }

    public function show(SpecificGarageRequest $request)
    {
        $id = $request->input('id');
        
        $garage = $this->garageRepository->find($id);
        if ($garage === null) {
            abort(404, 'Requested garage\'s not found !');
        }

        return view('homes.garage.showGarageOnMap', ['garage' => $garage]);
    }

    public function getInitParameters(Request $request) {
        if ($request->session()->has('getGaragesOptions')) {
            $givenConditions = $request->session()->get('getGaragesOptions');
        } else {
            $givenConditions = ['type' => 2, 'radius' => 1];
            $request->session()->put('getGaragesOptions', $givenConditions);
        }

        return [
            'status' => 1,
            'data' => $givenConditions,
        ];
    }
    
    public function getGarages(GettingGarageRequest $request)
    {
        $curPos = $request->input('curPos');
        $options =  $request->input('options');
        $garages = [];

        $garageFilterOpts = [];

        if ($request->session()->has('getGaragesOptions')) {
            foreach (array_keys($options) as $key) {
                $garageFilterOpts[$key] = $options[$key];
                $request->session()->put('getGaragesOptions.' . $key, $options[$key]);
            }
        } else {
            $request->session()->put('getGaragesOptions', $garageFilterOpts);
        }

        $givenConditions = $request->session()->get('getGaragesOptions');

//        dd($givenConditions);
        foreach ($givenConditions as $key => $value) {

            if ($key !== 'radius') {
//                dd($key . '-' . $value);
                $tmpCriteria = new WhereConditionCriteria($key, '=', $value);
                $this->garageRepository->pushCriteria($tmpCriteria);
//                dd($results = $this->garageRepository->all());
            } else {
                $rad = $givenConditions['radius'];
                $criteria = new NearestGaragesCriteria($curPos, $rad);
                $this->garageRepository->pushCriteria($criteria);
            }
        }

        $results = $this->garageRepository->all(['id', 'lat', 'lng','name', 'rating', 'short_description', 'type','avatar']);

        foreach ($results as $garage) {
            if ($this->isNear($curPos, $garage, $rad)) {
                array_push($garages, $garage);
            }
        }
        $this->response['data'] = $garages;

        return \Response::json($this->response);
    }

    public function getSpecificGarage(SpecificGarageRequest $request)
    {
        $id = $request->input('id');
        $garage = $this->garageRepository->find($id);
        $comments = $garage->comments;

        $ratings = $garage->ratings;
        $ratingStatistic = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $ratingTimes = sizeof($ratings);
        foreach ($ratings as $rating) {
            if (isset($ratingStatistic[$rating->score])) {
                $ratingStatistic[$rating->score] = $ratingStatistic[$rating->score] + 1;
            } else {
                $ratingStatistic[$rating->score] = 1;
            }
        }

        $visitRepo = App::make(VisitRepositoryInterface::class);

        $newVisitData = [
            'user_id' => Auth::user()->id,
            'visitable_id' => $garage->id,
            'visitable_type' => get_class($garage),
            'is_latest' => 1,
        ];

        $curLatest = $visitRepo->findWhere($newVisitData)->first();

        if ($curLatest !== null) {
            $visitRepo->update(['is_latest' => 0], $curLatest->id);
        }

        $visitRepo->create($newVisitData);
        
        $bookmarked = Auth::user()->getSpecificBookmark(get_class($garage), $garage->id);

        return view('homes.garage.garageDetail', ['garage' => $garage, 'bookmarked' => $bookmarked, 'ratingTimes' => $ratingTimes, 'comments' => $comments, 'ratingStatistic' => $ratingStatistic]);
    }

    /**
     * @param $curPos
     * @param $position
     * @param $rad (km)
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
