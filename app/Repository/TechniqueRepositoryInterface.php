<?php

namespace App\Repository;

use Ramsey\Collection\Collection;

interface TechniqueRepositoryInterface
{
    public function techniques(): Collection;

    public function getSubtechniques(): Collection;
}
