<?php

namespace Tests\Unit;

use App\DTO\ADMAbstract;
use App\DTO\ADMDataCollection;
use App\DTO\ADMRelationshipData;
use App\DTO\ADMSubtechniqueData;
use App\DTO\ADMTacticData;
use App\DTO\ADMTechniqueData;
use App\Http\Mitre\DatasetRequest;
use App\Http\Mitre\GetDatasetFromUriException;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class ADMCollectionTest extends TestCase
{
    /**
     * @return DatasetRequest
     * @throws GetDatasetFromUriException
     */
    public function testItCanReadDatasetFromUri(): DatasetRequest
    {
        $request = new DatasetRequest("https://raw.githubusercontent.com/mitre/cti/master/enterprise-attack/enterprise-attack.json");
        $request->get();

        $this->assertNotNull($request->getBody());
        $this->assertIsString($request->getBody());

        return $request;
    }

    /**
     * @depends testItCanReadDatasetFromUri
     * @param DatasetRequest $request
     * @return ADMDataCollection
     */
    public function testItCanCreateAdmCollectionFromDataset(DatasetRequest $request): ADMDataCollection
    {
        $bundle = $request->asArray()['objects'];

        $admDataCollection = ADMDataCollection::create($bundle);

        $this->assertGreaterThan(0, $admDataCollection->count());
        $this->assertInstanceOf(ADMAbstract::class, $admDataCollection[0]);

        return $admDataCollection;
    }

    /**
     * @depends testItCanCreateAdmCollectionFromDataset
     * @param ADMDataCollection $collection
     * @return ADMDataCollection
     */
    public function testItCanPerformSearchOnCollection(ADMDataCollection $collection): ADMDataCollection
    {
        $tactics = $collection->where('type', ADMAbstract::TYPE_TACTIC);

        $this->assertContainsOnlyInstancesOf(ADMTacticData::class, $tactics);
        $this->assertInstanceOf(ADMTacticData::class, $tactics->first());

        $attackPatterns = $collection->where('type', ADMAbstract::TYPE_TECHNIQUE);

        $techniques = $attackPatterns->where('x_mitre_is_subtechnique', false);

        $this->assertContainsOnlyInstancesOf(ADMTechniqueData::class, $techniques);
        $this->assertInstanceOf(ADMTechniqueData::class, $techniques->first());

        $subtechniques = $attackPatterns->where('x_mitre_is_subtechnique', true);

        $this->assertContainsOnlyInstancesOf(ADMSubtechniqueData::class, $subtechniques);
        $this->assertInstanceOf(ADMSubtechniqueData::class, $subtechniques->first());

        $relations = $collection->where('type', ADMAbstract::TYPE_RELATIONSHIP);

        $this->assertContainsOnlyInstancesOf(ADMRelationshipData::class, $relations);
        $this->assertInstanceOf(ADMRelationshipData::class, $relations->first());

        return $collection;
    }

    /**
     * @depends testItCanCreateAdmCollectionFromDataset
     * @param ADMDataCollection $collection
     */
    public function testItCanCreateRelationshipBetweenTechniqueAndItsSubtechniques(ADMDataCollection $collection)
    {
        /** @var ADMTechniqueData $technique */
        $technique = $collection->where('type', ADMAbstract::TYPE_TECHNIQUE)
            ->where('x_mitre_is_subtechnique', false)
            ->first();

        $this->assertInstanceOf(ADMTechniqueData::class, $technique);

        $technique->subtechniques = $this->getSubtechniques($technique, $collection);

        $this->assertContainsOnlyInstancesOf(ADMSubtechniqueData::class, $technique->subtechniques);
    }

    /**
     * @depends testItCanCreateAdmCollectionFromDataset
     * @param ADMDataCollection $collection
     */
    public function testItCanGetExternalIdsForTactics(ADMDataCollection $collection)
    {
        /** @var ADMTacticData[]|ADMDataCollection $tactics */
        $tactics = $collection->where('type', ADMAbstract::TYPE_TACTIC);

        $externalIds = $tactics->map(function ($tactic) {
            return $tactic->getExternalId();
        })->all();

        # Test that there are same values in
        $this->assertEquals(
            [],
            array_diff(
                $externalIds,
                ["TA0009", "TA0011", "TA0006", "TA0005", "TA0007", "TA0002", "TA0010", "TA0040", "TA0001", "TA0008", "TA0003", "TA0004", "TA0043", "TA0042"]
            ),
            "Failed asserting that two arrays contains the same values"
        );
    }

    /**
     * @depends testItCanCreateAdmCollectionFromDataset
     * @param ADMDataCollection $collection
     */
    public function testItCanCreateRelationshipBetweenTacticAndTechniques(ADMDataCollection $collection)
    {
        /** @var ADMTacticData[]|ADMDataCollection $tactics */
        $tactics = $collection->where('type', ADMAbstract::TYPE_TACTIC);

        foreach ($tactics as &$tactic) {
            $tactic->techniques = $this->getTacticTechniques($tactic, $collection);

            $this->assertContainsOnlyInstancesOf(ADMTechniqueData::class, $tactic->techniques);
        }
    }

    /**
     * @depends testItCanCreateAdmCollectionFromDataset
     * @param ADMDataCollection $collection
     */
    public function testItCanCreateRelationshipMatrixOfTacticsAndTechniquesAndSubtechniques(ADMDataCollection $collection)
    {
        /** @var ADMTacticData[]|ADMDataCollection $tactics */
        $tactics = $collection->where('type', ADMAbstract::TYPE_TACTIC);

        foreach ($tactics as &$tactic) {
            $tactic->techniques = $this->getTacticTechniques($tactic, $collection);

            $this->assertContainsOnlyInstancesOf(ADMTechniqueData::class, $tactic->techniques);

            foreach ($tactic->techniques as &$technique) {
                $technique->subtechniques = $this->getSubtechniques($technique, $collection);

                $this->assertContainsOnlyInstancesOf(ADMSubtechniqueData::class, $technique->subtechniques);
            }
        }
    }

    private function getTacticTechniques(ADMTacticData $tactic, ADMDataCollection $collection): ADMDataCollection
    {
        return $collection->where('type', ADMAbstract::TYPE_TECHNIQUE)
            ->where('x_mitre_is_subtechnique', false)
            ->filter(function ($item) use ($tactic) {
                return $item->getPhaseName() == $tactic->x_mitre_shortname;
            });
    }

    private function getSubtechniques(ADMTechniqueData $technique, ADMDataCollection $collection): ADMDataCollection
    {
        /** @var Collection|ADMRelationshipData[] $relations */
        $relations = $collection->where('type', ADMAbstract::TYPE_RELATIONSHIP)
            ->where('target_ref', $technique->id)
            ->where('relationship_type', ADMRelationshipData::RELATIONSHIP_SUBTECHNIQUE_OF);

        $this->assertContainsOnlyInstancesOf(ADMRelationshipData::class, $relations);

        return $collection->whereIn('id', $relations->map(function ($item) {
            return $item->source_ref;
        }));
    }
}
