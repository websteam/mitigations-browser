<?php

namespace App\Models\Traits;

trait HasExcerpt
{
    public function getExcerptAttribute()
    {
        $description = $this->attributes['description'];

        $lines = explode("\n", $description);

        return $lines[0];
    }
}
