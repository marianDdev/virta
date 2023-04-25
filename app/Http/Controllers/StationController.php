<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListStationsRequest;
use App\Http\Requests\StoreStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Http\Resources\StationResource;
use App\Models\Station;
use App\Services\StationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class StationController extends Controller
{
    public function index(ListStationsRequest $request, StationServiceInterface $service): Collection
    {
        $validated = $request->validated();

        return $service->list($validated);
    }

    public function getOne(StationServiceInterface $service, int $id): Station|JsonResponse
    {
        return $service->getOneById($id);
    }

    public function create(StoreStationRequest $request): JsonResponse
    {
        $validated = $request->validated();
        Station::create($validated);

        return response()->json('Station successfully created.', 201);
    }

    public function update(
        UpdateStationRequest    $request,
        StationServiceInterface $service,
        int                     $id
    ): StationResource
    {
        $validated = $request->validated();
        $station   = $service->getOneById($id);
        $station->update($validated);

        return new StationResource($station);
    }

    public function delete(StationServiceInterface $service, int $id): JsonResponse
    {
        $station = $service->getOneById($id);
        $station->delete();

        return response()->json('Station successfully deleted.');
    }
}
