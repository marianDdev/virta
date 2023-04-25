<?php

namespace Tests\Unit;

use App\Http\Controllers\StationController;
use App\Http\Requests\ListStationsRequest;
use App\Http\Resources\StationResourceCollection;
use App\Services\StationServiceInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class StationServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_get_all_stations(): void
    {
        $filters = [];

        $allStations = collect(
            [
                [
                    [
                        "id"         => 48,
                        "company_id" => 1,
                        "name"       => "Rau Inc",
                        "latitude"   => "55.09402200",
                        "longitude"  => "102.0303230",
                        "address"    => "75986 Beatty Lights\nEast Twilaburgh, CO 68441",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                    ],
                ],
                [
                    [
                        "id"         => 19,
                        "company_id" => 1,
                        "name"       => "D'Amore, Towne and Zemlak",
                        "latitude"   => "54.98277000",
                        "longitude"  => "93.8362690",
                        "address"    => "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                    ],
                ],
                [
                    [
                        "id"         => 20,
                        "company_id" => 2,
                        "name"       => "Boyer-Harber",
                        "latitude"   => "54.98277000",
                        "longitude"  => "93.8362690",
                        "address"    => "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                    ],
                ],
                [
                    [
                        "id"         => 21,
                        "company_id" => 3,
                        "name"       => "Jack & Sally",
                        "latitude"   => "33.98277000",
                        "longitude"  => "-102.8362690",
                        "address"    => "101 Lake Shmoal, OH 90505-4308",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                    ],
                ],
            ]
        );

        $request = self::createMock(ListStationsRequest::class);
        $request->expects(self::once())
                ->method('validated')
                ->willReturn($filters);


        $stationService = self::createMock(StationServiceInterface::class);
        $stationService->expects(self::once())
                       ->method('list')
                       ->with($filters)
                       ->willReturn($allStations);

        self::assertEquals(new StationResourceCollection($allStations), (new StationController())->index($request, $stationService));
    }

    /**
     * @throws Exception
     */
    public function test_get_stations_by_company_id(): void
    {
        $companyIdFilter = ['company_id' => 1];

        $filteredByCompanyId = collect(
            [
                "75986 Beatty Lights\nEast Twilaburgh, CO 68441"           => [
                    [
                        "id"         => 48,
                        "company_id" => 1,
                        "name"       => "Rau Inc",
                        "latitude"   => "55.09402200",
                        "longitude"  => "102.0303230",
                        "address"    => "75986 Beatty Lights\nEast Twilaburgh, CO 68441",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                        "distance"   => 129.75697962743638,
                    ],
                ],
                "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308" => [
                    [
                        "id"         => 19,
                        "company_id" => 1,
                        "name"       => "D'Amore, Towne and Zemlak",
                        "latitude"   => "54.98277000",
                        "longitude"  => "93.8362690",
                        "address"    => "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                        "distance"   => 393.077139468085,
                    ],
                ],
            ]
        );

        $requestWithCompanyId = self::createMock(ListStationsRequest::class);
        $requestWithCompanyId->expects(self::once())
                             ->method('validated')
                             ->willReturn($companyIdFilter);


        $stationService = self::createMock(StationServiceInterface::class);
        $stationService->expects(self::once())
                       ->method('list')
                       ->with($companyIdFilter)
                       ->willReturn($filteredByCompanyId);

        self::assertEquals(new StationResourceCollection($filteredByCompanyId), (new StationController())->index($requestWithCompanyId, $stationService));
    }

    /**
     * @throws Exception
     */
    public function test_get_stations_by_coordinates(): void
    {
        $coordinatesFilters = [
            'latitude'  => 55,
            'longitude' => 100,
            'radius'    => 444,
        ];

        $filteredByCoordinates = collect(
            [
                "75986 Beatty Lights\nEast Twilaburgh, CO 68441"           => [
                    [
                        "id"         => 48,
                        "company_id" => 1,
                        "name"       => "Rau Inc",
                        "latitude"   => "55.09402200",
                        "longitude"  => "102.0303230",
                        "address"    => "75986 Beatty Lights\nEast Twilaburgh, CO 68441",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                        "distance"   => 129.75697962743638,
                    ],
                ],
                "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308" => [
                    [
                        "id"         => 19,
                        "company_id" => 1,
                        "name"       => "D'Amore, Towne and Zemlak",
                        "latitude"   => "54.98277000",
                        "longitude"  => "93.8362690",
                        "address"    => "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                        "distance"   => 393.077139468085,
                    ],
                    [
                        "id"         => 20,
                        "company_id" => 2,
                        "name"       => "Boyer-Harber",
                        "latitude"   => "54.98277000",
                        "longitude"  => "93.8362690",
                        "address"    => "205 Parker Shoals Apt. 607\nNorth Anatown, OH 90505-4308",
                        "created_at" => "2023-04-24T00:00:00.000000Z",
                        "updated_at" => "2023-04-24T00:00:00.000000Z",
                        "distance"   => 393.077139468085,
                    ],
                ],
            ]
        );


        $requestWithCoordinates = self::createMock(ListStationsRequest::class);
        $requestWithCoordinates->expects(self::once())
                               ->method('validated')
                               ->willReturn($coordinatesFilters);

        $stationService = self::createMock(StationServiceInterface::class);
        $stationService->expects(self::once())
                       ->method('list')
                       ->with($coordinatesFilters)
                       ->willReturn($filteredByCoordinates);

        self::assertEquals(new StationResourceCollection($filteredByCoordinates), (new StationController())->index($requestWithCoordinates, $stationService));
    }

    /**
     * @throws Exception
     */
    public function test_get_no_stations(): void
    {
        $companyIdFilter = ['company_id' => 10];

        $requestNoStations = self::createMock(ListStationsRequest::class);
        $requestNoStations->expects(self::once())
                          ->method('validated')
                          ->willReturn(['company_id' => 10]);


        $stationService = self::createMock(StationServiceInterface::class);
        $stationService->expects(self::once())
                       ->method('list')
                       ->with($companyIdFilter)
                       ->willReturn(collect([]));

        self::assertEquals(new StationResourceCollection(collect([])), (new StationController())->index($requestNoStations, $stationService));
    }
}
