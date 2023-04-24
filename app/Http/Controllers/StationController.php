<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Services\StationServiceInterface;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request, StationServiceInterface $service)
    {
        return $service->list($request->all());
    }

    public function getOne(Station $station)
    {
        //
    }

    public function create()
    {
        //
    }

    public function update(Request $request, Station $station)
    {
        //
    }

    public function delete(Station $station)
    {
        //
    }
}
