<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\JsonResponse;

interface CompanyServiceInterface
{
    public function getOneById(int $id): Company|JsonResponse;

    public function removeParentCompany(Company $company): void;
}
