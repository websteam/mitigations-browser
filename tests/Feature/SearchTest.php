<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function testItCanDoSearch()
    {
        $response = $this->get('/search?query=test');

        $response
            ->assertStatus(200)
            ->assertDontSeeText('No results found.');
    }

    public function testItCanDoUnsuccessfulSearch()
    {
        $response = $this->get('/search?query=some_dummy_query_123#');

        $response
            ->assertStatus(200)
            ->assertSeeText('No results found.');
    }
}
