<?php

namespace App\Models;

use App\Models\Traits\HasExcerpt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Technique
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Technique extends Model
{
    use HasFactory, HasExcerpt;

    protected $table = 'techniques';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'parent_id',
        'external_id',
        'name',
        'description',
        'version',
        'created_at',
        'modified_at',
    ];

    public function tactics(): BelongsToMany
    {
        return $this->belongsToMany(Tactic::class);
    }

    public function subtechniques(): HasMany
    {
        return $this->hasMany(Technique::class, 'parent_id')->orderBy('external_id');
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class, 'parent_id', 'id');
    }

    /**
     * @return bool
     */
    public function getIsSubtechniqueAttribute(): bool
    {
        return null !== $this->attributes['parent_id'];
    }
}
