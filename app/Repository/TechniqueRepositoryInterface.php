<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

interface TechniqueRepositoryInterface extends EloquentRepositoryInterface
{
    public function allTechniques(): Collection;

    public function allSubtechniques(): Collection;
}
