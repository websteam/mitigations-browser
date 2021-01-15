<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tactic extends Model
{
    use HasFactory;

    protected $table = 'tactics';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'external_id',
        'name',
        'slug',
        'description',
        'created_at',
        'modified_at',
    ];
}
