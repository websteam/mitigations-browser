<?php

namespace App\Repository\Eloquent;

use App\DTO\ADMTacticData;
use App\Models\Tactic;
use App\Repository\Eloquent\Traits\FindByExternalId;
use App\Repository\TacticRepositoryInterface;
use Illuminate\Support\Carbon;

class TacticRepository extends BaseRepository implements TacticRepositoryInterface
{
    use FindByExternalId;

    /**
     * UserRepository constructor.
     *
     * @param Tactic $model
     */
    public function __construct(Tactic $model)
    {
        parent::__construct($model);
    }

    public function fromAdm(ADMTacticData $tactic): array
    {
        return [
            'id' => $tactic->id,
            'external_id' => $tactic->getExternalId(),
            'name' => $tactic->name,
            'slug' => $tactic->x_mitre_shortname,
            'description' => $tactic->description,
            'created_at' => $tactic->created,
            'updated_at' => $tactic->modified
        ];
    }
}
