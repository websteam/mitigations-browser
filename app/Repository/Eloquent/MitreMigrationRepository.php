<?php


namespace App\Repository\Eloquent;


use App\Models\MitreMigration;
use App\Repository\MitreMigrationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MitreMigrationRepository extends BaseRepository implements MitreMigrationRepositoryInterface
{
    public function __construct(MitreMigration $model)
    {
        parent::__construct($model);
    }

    /**
     * Creates new mitre migration with today date
     *
     * @inheritDoc
     */
    public function create(array $attributes = []): MitreMigration
    {
        return $this->model->create([
            'migration_date' => new \DateTime()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function find($id): ?MitreMigration
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
