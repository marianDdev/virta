<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        //
    }

    public function create(StoreCompanyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        Company::create($validatedData);

        return response()->json('Company successfully created.');
    }

    public function update(Request $request, Company $company)
    {
        //
    }

    public function destroy(Company $company)
    {
        //
    }
}
