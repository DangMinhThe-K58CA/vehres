<?php
/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 3/13/2017
 * Time: 5:22 PM
 */

namespace App\Repositories\Criteria;

use App\Repositories\Contracts\RepositoryInterface as Repository;

class NearestGaragesCriteria extends Criteria
{
    /**
     * Length of a decimal degree lat, lng in km.
     */
    const LENGTH_OF_DECIMAL_DEGREE = 111.32;

    private $curPos;
    private $radius;

    public function __construct($curPos, $rad)
    {
        $this->curPos = $curPos;
        $this->radius = $rad;
    }

    public function apply($model, Repository $repository)
    {
        // TODO: Implement apply() method.

        $boundedLatLng = $this->boundedLatLng();
//        dd($boundedLatLng);
        $query = $model->whereBetween('lat', $boundedLatLng['lat'])
                        ->whereBetween('lng', $boundedLatLng['lng']);

        return $query;
    }

    private function boundedLatLng()
    {
        $curPos = $this->curPos;
        $rad = $this->radius;

        $stepDegree = $rad / self::LENGTH_OF_DECIMAL_DEGREE;

        $lowBoundedLat = $curPos['lat'] - $stepDegree;
        $highBoundedLat = $curPos['lat'] + $stepDegree;

        $lowBoundedLng = $curPos['lng'] - $stepDegree;
        $highBoundedLng = $curPos['lng'] + $stepDegree;

        $boundedLatLng = [
            'lat' => [$lowBoundedLat, $highBoundedLat],
            'lng' => [$lowBoundedLng, $highBoundedLng]
        ];

        return $boundedLatLng;
    }
}
