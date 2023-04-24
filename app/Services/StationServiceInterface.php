<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface StationServiceInterface
{
    public function list(array $filters): Collection;
}
