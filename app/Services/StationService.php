<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Support\Collection;

class StationService implements StationServiceInterface
{
    /** Aproximative ength of on degree latitude at ecuator */
    const LATITUDE_ONE_DEGREE = 111;

    public function list(array $filters): Collection
    {
        //$stations = Station::all();
        $stations = Station::all();

        if (!empty($filters['company_id'])) {
            $company  = Company::find($filters['company_id']);
            $stations = $stations->whereIn('company_id', $this->getIds($company));
        }

        $locationFilters = ['latitude', 'longitude', 'radius'];

        $locationFiltersExist = array_intersect($locationFilters, array_keys($filters)) === $locationFilters;

        if ($locationFiltersExist) {
            $coordinatesRanges = $this->calculateLocation($filters['latitude'], $filters['longitude'], $filters['radius']);
            $stations          = $stations->whereBetween('latitude', $coordinatesRanges['lat'])
                                          ->whereBetween('longitude', $coordinatesRanges['long']);
        }

        return $stations;
    }

    private function getIds(Company $company): array
    {
        $ids = [$company->id];
        foreach ($company->children as $child) {
            $ids = array_merge($ids, $this->getIds($child));
        }

        return $ids;
    }

    private function calculateLocation($lat, $long, $radius): array
    {
        //convert latitude degrees into radians
        $latToradians = $lat * (pi() / 180);

        // take the cosine of radians
        $cosRadians = cos($latToradians);

        //one degree of longitude based on latitude
        $oneDegreeLong = $cosRadians * self::LATITUDE_ONE_DEGREE;

        //convert radius from km into degrees
        $radiusToLatDregrees = $radius / self::LATITUDE_ONE_DEGREE;
        $radiusToLongDegrees = $radius / $oneDegreeLong;

        //return distance ranges in degrees for W-E, N-S
        return [
            'lat'  => [$lat - $radiusToLatDregrees, $lat + $radiusToLatDregrees],
            'long' => [$long - $radiusToLongDegrees, $long + $radiusToLongDegrees],
        ];
    }
}
