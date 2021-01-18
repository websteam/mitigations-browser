<?php


namespace App\Repository\Eloquent\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait FindByExternalId
 * @package App\Repository\Eloquent
 * @property Model $model
 */
trait FindByExternalId
{
    public function findByExternalId(string $externalId)
    {
        return $this->model->where('external_id', $externalId)->firstOrFail();
    }
}
