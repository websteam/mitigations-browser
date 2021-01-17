<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MitreAttackCommandTest extends TestCase
{
    public function testItCanInvokeCommandWithCancel()
    {
        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', false)
            ->expectsOutput('Ok. Bye!')
            ->assertExitCode(0);
    }

    public function testItCanInvokeCommandWithConfirmation()
    {
        $this->artisan('mitre:attack')
            ->expectsConfirmation('Do you wish to continue? This action is *IRREVERSIBLE*', true)
            ->expectsOutput('Fetching json data...');
    }
}
