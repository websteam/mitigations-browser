<?php

namespace App\Repository\Eloquent;

use App\DTO\ADMAbstract;
use App\DTO\ADMSubtechniqueData;
use App\DTO\ADMTechniqueData;
use App\Models\Technique;
use App\Repository\Eloquent\Traits\FindByExternalId;
use App\Repository\TechniqueRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TechniqueRepository extends BaseRepository implements TechniqueRepositoryInterface
{
    use FindByExternalId;

    /**
     * UserRepository constructor.
     *
     * @param Technique $model
     */
    public function __construct(Technique $model)
    {
        parent::__construct($model);
    }

    /**
     * @param ADMTechniqueData|ADMSubtechniqueData|ADMAbstract $technique
     * @return Technique
     */
    public function fromAdm(ADMAbstract $technique): Technique
    {
        return new Technique([
            'id' => $technique->id,
            'external_id' => $technique->getExternalId(),
            'name' => $technique->name,
            'description' => $technique->description,
            'created_at' => $technique->created,
            'updated_at' => $technique->modified
        ]);
    }

    public function allTechniques(): Collection
    {
        return $this->model->where('parent_id', null)->get();
    }

    public function allSubtechniques(): Collection
    {
        return $this->model->where('parent_id', '<>', 'null')->get();
    }
}
