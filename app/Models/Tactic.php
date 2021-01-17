<?php

namespace App\Models;

use App\Models\Traits\HasExcerpt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function techniques()
    {
        return $this->belongsToMany(Technique::class);
    }
}
