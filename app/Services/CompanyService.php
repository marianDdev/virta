<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyService
{
    public function getOneById(int $id): Company|JsonResponse
    {
        $company = Company::find($id);

        if (is_null($company)) {
            return response()->json('Company not found.', 404);
        }

        return $company;
    }

    public function removeParentCompany(int $parentId): void
    {
        $children = Company::where('parent_company_id', $parentId)->get();

        if ($children->count() > 0) {
            foreach ($children as $company) {
                $company->update(['parent_company_id' =>  null]);
            }
        }
    }
}
