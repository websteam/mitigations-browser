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
     */
    public function testItCanPerformSearchOnCollection(ADMDataCollection $collection)
    {
        $tactics = $collection->where('type', 'x-mitre-tactic');

        $this->assertContainsOnlyInstancesOf(ADMTacticData::class, $tactics);
        $this->assertInstanceOf(ADMTacticData::class, $tactics->first());

        $attackPatterns = $collection->where('type', 'attack-pattern');

        $techniques = $attackPatterns->where('x_mitre_is_subtechnique', false);

        $this->assertContainsOnlyInstancesOf(ADMTechniqueData::class, $techniques);
        $this->assertInstanceOf(ADMTechniqueData::class, $techniques->first());

        $subtechniques = $attackPatterns->where('x_mitre_is_subtechnique', true);

        $this->assertContainsOnlyInstancesOf(ADMSubtechniqueData::class, $subtechniques);
        $this->assertInstanceOf(ADMSubtechniqueData::class, $subtechniques->first());

        $relations = $collection->where('type', 'relationship');

        $this->assertContainsOnlyInstancesOf(ADMRelationshipData::class, $relations);
        $this->assertInstanceOf(ADMRelationshipData::class, $relations->first());
    }

    public function testItCanCreateRelationshipBetweenTechniqueAndItsSubtechniques()
    {

    }

    public function testItCanCreateRelationshipBetweenTacticAndTechniques()
    {

    }

    public function testItCanCreateRelationshipMatrixOfTacticsAndTechniquesAndSubtechniques()
    {

    }
}
