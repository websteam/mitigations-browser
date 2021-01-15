<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatasetJsonParseTest extends TestCase
{
    public function testItCanReadTestedFile(): string
    {
        $uri = config('mitre.dataset_uri');

        $fileContents = \file_get_contents($uri);

        $this->assertNotFalse($fileContents);
        $this->assertIsString($fileContents);

        return $fileContents;
    }

    /**
     * @depends testItCanReadTestedFile
     * @param string $fileContents
     * @return array
     */
    public function testItDecodeFileIntoJsonAndGetFirstObject(string $fileContents): array
    {
        $this->assertJson($fileContents);

        $jsonData = \json_decode($fileContents, true);

        $firstObject = $jsonData['objects'][0];

        $this->assertIsArray($firstObject);
        $this->assertArrayHasKey('id', $firstObject);

        return $jsonData['objects'];
    }

    /**
     * @depends testItDecodeFileIntoJsonAndGetFirstObject
     * @param array $jsonData
     * @return void
     */
    public function testItCanGroupObjectsByType(array $jsonData)
    {
        $groupedByType = [];

        foreach ($jsonData as $object) {
            $groupedByType[$object['type']][] = $object;
        }

        $this->assertGreaterThan(0, count($groupedByType));
        $this->assertArrayHasKey('attack-pattern', $groupedByType);
    }
}
