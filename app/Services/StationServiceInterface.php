<?php

namespace App\Services;

use App\Models\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface StationServiceInterface
{
    public function list(array $filters): Collection;

    public function getOneById(int $id): Station|JsonResponse;
}
