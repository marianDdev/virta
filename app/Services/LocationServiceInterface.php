<?php

namespace App\Services;

interface LocationServiceInterface
{
    /** Aproximative length of one degree latitude at ecuator */
    public const LATITUDE_ONE_DEGREE = 111;

    public function calculateLocation($lat, $long, $radius): array;
}
