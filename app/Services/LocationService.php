<?php

namespace App\Services;

class LocationService implements LocationServiceInterface
{

    public function calculateLocation($lat, $long, $radius): array
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
