<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MitreAttackCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh');
    }

    public function testItCanInvokeCommandWithCancel()
    {
        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', 'no')
            ->expectsOutput('Ok. Bye!')
            ->assertExitCode(0);
    }

    public function testItCanInvokeCommandWithConfirmation()
    {
        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', 'yes')
            ->expectsOutput('Fetching json data...')
            ->expectsOutput('Building relationships...')
            ->expectsOutput('Populating database...')
            ->assertExitCode(0);
    }
}
