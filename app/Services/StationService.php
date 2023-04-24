<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Support\Collection;

class StationService implements StationServiceInterface
{
    private LocationServiceInterface $locationService;

    public function __construct(LocationServiceInterface $locationService)
    {
        $this->locationService = $locationService;
    }

    public function list(array $filters): Collection
    {
        $locationFilters      = ['latitude', 'longitude', 'radius'];
        $locationFiltersExist = array_intersect($locationFilters, array_keys($filters)) === $locationFilters;

        return Station::when(!empty($filters['company_id']), function ($query) use ($filters) {
            $company = Company::find($filters['company_id']);

            return $query->whereIn('company_id', $this->getIds($company));
        })
                      ->when($locationFiltersExist, function ($query) use ($filters) {
                          $coordinatesRanges = $this->locationService->calculateLocation($filters['latitude'], $filters['longitude'], $filters['radius']);

                          return $query->whereBetween('latitude', $coordinatesRanges['lat'])
                                       ->whereBetween('longitude', $coordinatesRanges['long']);
                      })
                      ->get();
    }

    private function getIds(Company $company): array
    {
        $ids = [$company->id];
        foreach ($company->children as $child) {
            $ids = array_merge($ids, $this->getIds($child));
        }

        return $ids;
    }
}
