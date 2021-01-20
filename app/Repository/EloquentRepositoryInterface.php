<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model;

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @return Model|null
     */
    public function first(): ?Model;

    /**
     * @return Model|null
     */
    public function last(): ?Model;
}
