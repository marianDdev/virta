<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['required', 'integer', Rule::exists(Company::class, 'id')],
            'name'       => ['required', 'string', 'max:256'],
            'latitude'   => ['required', 'numeric', 'between:-90,90'],
            'longitude'  => ['required', 'numeric', 'between:-180,180'],
            'address'    => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.exists' => 'Parent company id must be an existing company id.',
            'latitude.between'  => 'Latitude must be a value between -90 and 90',
            'longitude.between' => 'Longitude mus be a value between -180 and 180',
        ];

    }
}
