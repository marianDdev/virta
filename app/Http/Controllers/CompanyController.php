<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyResourceCollection;
use App\Models\Company;
use App\Services\CompanyServiceInterface;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function index(): CompanyResourceCollection
    {
        return new CompanyResourceCollection(Company::all());
    }

    public function getOne(CompanyServiceInterface $service, int $id): JsonResponse|CompanyResource
    {
        $company = $service->getOneById($id);

        return new CompanyResource($company);
    }

    public function create(StoreCompanyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        Company::create($validatedData);

        return response()->json('Company successfully created.', 201);
    }

    public function update(CompanyServiceInterface $service, UpdateCompanyRequest $request, int $id): CompanyResource
    {
        $company   = $service->getOneById($id);
        $validated = $request->validated();
        $company->update($validated);

        return new CompanyResource($company);
    }

    public function delete(CompanyServiceInterface $service, int $id): JsonResponse
    {
        $company = $service->getOneById($id);
        $service->removeParentCompany($company);
        $company->delete();

        return response()->json('Company successfully deleted.');
    }
}
