<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property Collection $children
 * @property Collection $grandchildren
 * @property Collection $stations
 * @property Collection $childrenStations
 * @property Collection $grandchildrenStations
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = ['parent_company_id', 'name'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_company_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_company_id');
    }

    public function grandchildren(): HasMany
    {
        return $this->children()->with('grandchildren');
    }

    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }
}
