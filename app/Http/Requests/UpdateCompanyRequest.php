<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_company_id' => ['nullable', 'integer', Rule::exists(Company::class, 'id'), Rule::notIn(request()->route('id'))],
            'name'              => ['nullable', 'string', 'max:256'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_company_id.exists' => 'There is no company with the given id. Please choose an existing one as parent.',
            'parent_company_id.not_in' => 'Please choose a parent company id different than the id of the company that your are updating.',
        ];
    }
}
