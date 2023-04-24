<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property string     $name
 * @property Collection $grandChildren
 * @property integer    $parent_company_id
 * @property Company    $parent
 */
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'     => $this->name,
            'parent'   => $this->parent->name ?? null,
            'children' => $this->grandChildren,
        ];
    }
}
