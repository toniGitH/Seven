<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Manually added method to the framework
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    // Manually added method to the framework
    private function setUpDatabase(): void
    {
        // Ensure migrations are run
        Artisan::call('migrate');
        
        // Create Passport personal access client using the official command
        Artisan::call('passport:client', [
            '--personal' => true,
            '--name' => 'Personal Access Client',
            '--no-interaction' => true,
        ]);
        
        $this->seed();
    }
}

