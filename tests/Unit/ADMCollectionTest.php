<?php

namespace Tests\Unit;

use App\DTO\ADMAbstract;
use App\DTO\ADMDataCollection;
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
     */
    public function testItCanCreateSdoCollectionFromDataset(DatasetRequest $request)
    {
        $bundle = $request->asArray()['objects'];

        $admDataCollection = ADMDataCollection::create($bundle);

        $this->assertGreaterThan(0, count($admDataCollection));
        $this->assertInstanceOf(ADMAbstract::class, $admDataCollection[0]);
    }

    public function testItCanCreateRelationshipBetweenTechniqueAndItsSubtechniques()
    {

    }

    public function testItCanCreateRelationshipBetweenTacticAndTechniques()
    {

    }

    public function testItCanCreateRelationshipMatrixOfTacticTechniquesAndSubtechniques()
    {

    }
}
