<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technique extends Model
{
    use HasFactory;

    protected $table = 'techniques';
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
}
