<?php

namespace App\Repository\Eloquent;

use App\DTO\ADMTacticData;
use App\Models\Tactic;
use App\Repository\TacticRepositoryInterface;

class TacticRepository extends BaseRepository implements TacticRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Tactic $model
     */
    public function __construct(Tactic $model)
    {
        parent::__construct($model);
    }

    public function fromAdm(ADMTacticData $tactic): Tactic
    {
        return new Tactic([
            'id' => $tactic->id,
            'external_id' => $tactic->getExternalId(),
            'name' => $tactic->name,
            'slug' => $tactic->x_mitre_shortname,
            'description' => $tactic->description,
            'created_at' => $tactic->created,
            'updated_at' => $tactic->modified
        ]);
    }

    public function findByExternalId(string $externalId)
    {
        return $this->model->where('external_id', $externalId)->first();
    }
}
