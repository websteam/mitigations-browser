<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TacticTechnique extends Pivot
{
    public $incrementing = true;

    protected $fillable = ['tactic_id', 'technique_id'];
}
