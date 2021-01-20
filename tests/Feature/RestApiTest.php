<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestApiTest extends TestCase
{
    const TEST_TECHNIQUE_ID = 'T1055.011';

    public function testTacticsCollectionRequestIsAccessibleAndHasValidStructure()
    {
        $response = $this->getJson('/api/tactics');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'external_id',
                    'name',
                    'slug',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testTechniquesCollectionRequestIsAccessibleAndHasValidStructure()
    {
        $response = $this->getJson('/api/techniques');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'parent_id',
                    'external_id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testTechniqueByExternalIdIsAccessibleAndHasValidStructure()
    {
        $response = $this->getJson('/api/techniques/' . self::TEST_TECHNIQUE_ID);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'parent_id',
                'external_id',
                'name',
                'description',
                'created_at',
                'updated_at'
            ]);
    }

    public function testTechniqueWithInvalidOrNoExistingIdReturnsHttpStatus404()
    {
        $response = $this->getJson('/api/techniques/some_dummy_endpoint');

        $response->assertStatus(404);
    }
}
