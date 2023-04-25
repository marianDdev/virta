<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class StationService implements StationServiceInterface
{
    public function list(array $filters): Collection
    {
        $locationFilters      = ['latitude', 'longitude', 'radius'];
        $locationFiltersExist = array_intersect($locationFilters, array_keys($filters)) === $locationFilters;

        return Station::when(!empty($filters['company_id']), function ($query) use ($filters) {
            $company = Company::find($filters['company_id']);

            return $query->whereIn('company_id', $this->getIds($company));
        })->when($locationFiltersExist, function ($query) use ($filters) {
            $haversine = $this->getHaversine($filters);

            return $query->select('*')
                         ->selectRaw("$haversine AS distance")
                         ->having("distance", "<=", $filters['radius'])
                         ->orderby("distance", "asc");
        })
                      ->get()
                      ->groupBy("address");
    }

    public function getOneById(int $id): Station|JsonResponse
    {
        $station = Station::find($id);

        if (is_null($station)) {
            return response()->json('Station not found.', 404);
        }

        return $station;
    }

    private function getIds(Company $company): array
    {
        $ids = [$company->id];
        foreach ($company->children as $child) {
            $ids = array_merge($ids, $this->getIds($child));
        }

        return $ids;
    }

    /**
     * The haversine formula determines the great-circle distance between two points on a sphere
     * given their longitudes and latitudes
     */
    private function getHaversine(array $filters): string
    {
        return "(
        6371 * acos(
            cos(radians(" . $filters['latitude'] . "))
            * cos(radians(`latitude`))
            * cos(radians(`longitude`) - radians(" . $filters['longitude'] . "))
            + sin(radians(" . $filters['latitude'] . ")) * sin(radians(`latitude`))
            )
        )";
    }
}
