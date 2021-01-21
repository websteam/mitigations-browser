<?php

namespace Tests\Unit;

use App\Http\Mitre\DatasetRequest;
use App\Http\Mitre\GetDatasetFromUriException;
use Tests\TestCase;

class DatasetJsonParseTest extends TestCase
{
    /**
     * @throws GetDatasetFromUriException
     */
    public function testItCouldNotGetDatasetFromNonAccessibleUri()
    {
        $request = new DatasetRequest('http://unexisting.domain.com');

        $this->expectException(GetDatasetFromUriException::class);

        $request->get();

        $this->assertNull($request->getBody());
    }

    /**
     * @return DatasetRequest
     * @throws GetDatasetFromUriException
     */
    public function testItCanReadTestedFile(): DatasetRequest
    {
        $request = new DatasetRequest();
        $request->get();

        $this->assertNotNull($request->getBody());
        $this->assertIsString($request->getBody());

        return $request;
    }

    /**
     * @depends testItCanReadTestedFile
     * @param DatasetRequest $request
     * @return array
     */
    public function testItDecodeRequestBodyIntoJsonAndGetFirstObject(DatasetRequest $request): array
    {
        $this->assertJson($request->getBody());

        $data = $request->asArray();

        $firstObject = $data['objects'][0];

        $this->assertIsArray($firstObject);
        $this->assertArrayHasKey('id', $firstObject);

        return $data['objects'];
    }

    /**
     * @depends testItDecodeRequestBodyIntoJsonAndGetFirstObject
     * @param array $data
     * @return void
     */
    public function testItCanGroupObjectsByType(array $data)
    {
        $groupedByType = [];

        foreach ($data as $object) {
            $groupedByType[$object['type']][] = $object;
        }

        $this->assertGreaterThan(0, count($groupedByType));
        $this->assertArrayHasKey('attack-pattern', $groupedByType);
    }
}
