<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_company_id' => ['nullable', 'integer', Rule::exists(Company::class, 'id')],
            'name' =>['required', 'string', 'max:256']
        ];
    }

    public function messages(): array
    {
        return [
          'parent_company_id.exists' => 'There is no company with the given id. Please choose an existing one as parent.'
        ];
    }
}
