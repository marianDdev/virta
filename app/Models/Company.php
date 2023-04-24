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
}
