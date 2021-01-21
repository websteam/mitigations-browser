<?php

namespace App\Console\Commands;

use App\DTO\ADMAbstract;
use App\DTO\ADMDataCollection;
use App\DTO\ADMRelationshipData;
use App\DTO\ADMTacticData;
use App\Http\Mitre\DatasetRequest;
use App\Http\Mitre\GetDatasetFromUriException;
use App\Repository\Eloquent\MitreMigrationRepository;
use App\Repository\Eloquent\TacticRepository;
use App\Repository\Eloquent\TechniqueRepository;
use App\Repository\TacticRepositoryInterface;
use App\Repository\TechniqueRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MitreAttack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mitre:attack {sure?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to obtain dataset from Mitre\'s ATT&CK official repository and store it into application database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param TacticRepository|TacticRepositoryInterface $tacticRepository
     * @param TechniqueRepository|TechniqueRepositoryInterface $techniqueRepository
     * @param MitreMigrationRepository $migrationRepository
     * @return int
     */
    public function handle(
        TacticRepositoryInterface $tacticRepository,
        TechniqueRepositoryInterface $techniqueRepository,
        MitreMigrationRepository $migrationRepository
    ): int
    {
        $sure = $this->argument('sure');

        if ($sure || $this->confirm('Do you wish to continue? This action is *IRREVERSIBLE*', true)) {
            $this->line('Fetching json data...');

            try {
                $request = new DatasetRequest();
                $request->get();

                $this->line('Building relationships...');

                $bundle = $request->asArray()['objects'];
                $collection = ADMDataCollection::create($bundle);

                $sampleTactic = $tacticRepository->first();
                $lastMigration = $migrationRepository->last();

                if (!is_null($lastMigration) && $sampleTactic->exists) {
                    $this->info('There is already some data in database.');
                    $this->info('Preparing data for update...');

                    $collection = $collection->where('modified', '>', $lastMigration->migration_date);

                    if ($collection->count() == 0) {
                        $this->info('Nothing to update. Exiting now.');

                        return 2;
                    }
                }

                $this->line('Populating database...');

                $this->output->progressStart(
                    $collection->whereIn(
                        'type',
                        [ADMAbstract::TYPE_TACTIC, ADMAbstract::TYPE_TECHNIQUE]
                    )->count()
                );

                /** @var ADMTacticData[]|ADMDataCollection $tactics */
                $tactics = $collection
                    ->where('type', ADMAbstract::TYPE_TACTIC);

                DB::beginTransaction();

                foreach ($tactics as &$tactic) {
                    $tacticEntity = $tacticRepository->fromAdm($tactic);
                    $tacticEntity->save();

                    $tactic->techniques = $collection->where('type', ADMAbstract::TYPE_TECHNIQUE)
                        ->where('x_mitre_is_subtechnique', false)
                        ->filter(function ($item) use ($tactic) {
                            return $item->getPhaseName() == $tactic->x_mitre_shortname;
                        });

                    $techniques = [];

                    foreach ($tactic->techniques as &$technique) {
                        $techniqueEntity = $techniqueRepository->fromAdm($technique);
                        $techniqueEntity->setAttribute('id', $technique->id);
                        $techniqueEntity->save();

                        /** @var Collection|ADMRelationshipData[] $relations */
                        $relations = $collection->where('type', ADMAbstract::TYPE_RELATIONSHIP)
                            ->where('target_ref', $technique->id)
                            ->where('relationship_type', ADMRelationshipData::RELATIONSHIP_SUBTECHNIQUE_OF);

                        $technique->subtechniques = $collection->whereIn('id', $relations->map(function ($item) {
                            return $item->source_ref;
                        }));

                        foreach ($technique->subtechniques as &$subtechnique) {
                            $subtechniqueEntity = $techniqueRepository->fromAdm($subtechnique);
                            $subtechniqueEntity->parent_id = $technique->id;
                            $subtechniqueEntity->save();

                            $this->output->progressAdvance();
                        }

                        $techniques[] = $techniqueEntity->id;

                        $this->output->progressAdvance();
                    }

                    $tacticEntity->techniques()->sync($techniques);

                    $this->output->progressAdvance();
                }

                $this->output->progressFinish();

            } catch (QueryException $e) {
                DB::rollBack();

                $this->error($e->getMessage());

                return 1;
            } catch (GetDatasetFromUriException $e) {
                $this->error('Unable to get dataset from uri. Service might be unavailable at the time. Please try again later.');

                return 2;
            } catch (\Throwable $e) {
                $this->error('There was an error: ' . $e->getMessage());

                return $e->getCode();
            }

            $migrationRepository->create();
            DB::commit();

            return 0;
        }

        $this->info('Ok. Bye!');

        return 0;
    }
}
