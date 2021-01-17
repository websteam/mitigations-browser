<?php

namespace App\Models;

use App\Models\Traits\HasExcerpt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public $timestamps = true;

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

    public function tactics()
    {
        return $this->belongsToMany(Tactic::class);
    }

    public function subtechniques()
    {
        return $this->hasMany(Technique::class, 'parent_id')->with('subtechniques');
    }

    public function technique()
    {
        return $this->belongsTo(Technique::class, 'parent_id')->where('parent_id', 0)->with('parent');
    }
}
