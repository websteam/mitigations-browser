<?php

namespace App\Models;

use App\Models\Traits\HasExcerpt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Tactic
 * @package App\Models
 * @mixin Builder
 */
class Tactic extends Model
{
    use HasFactory, HasExcerpt;

    protected $table = 'tactics';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'external_id',
        'name',
        'slug',
        'description',
        'created_at',
        'updated_at',
    ];

    public function techniques(): BelongsToMany
    {
        return $this->belongsToMany(Technique::class);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
