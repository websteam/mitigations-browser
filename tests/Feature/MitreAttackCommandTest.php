<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MitreAttackCommandTest extends TestCase
{
    public function testItCanInvokeCommandWithCancel()
    {
        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', 'no')
            ->expectsOutput('Ok. Bye!')
            ->assertExitCode(0);
    }

    public function testItCanInvokeCommandWithConfirmation()
    {
        Artisan::call('migrate:fresh');

        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', 'yes')
            ->expectsOutput('Fetching json data...')
            ->expectsOutput('Building relationships...')
            ->expectsOutput('Populating database...')
            ->assertExitCode(0);
    }

    /**
     * @depends testItCanInvokeCommandWithConfirmation
     */
    public function testItWouldTryToUpdateWithNothingToUpdate()
    {
        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', 'yes')
            ->expectsOutput('Fetching json data...')
            ->expectsOutput('Building relationships...')
            ->expectsOutput('There is already some data in database.')
            ->expectsOutput('Preparing data for update...')
            ->expectsOutput('Nothing to update. Exiting now.')
            ->assertExitCode(2);
    }
}
