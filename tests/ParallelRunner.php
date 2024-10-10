<?php

namespace Tests;

class ParallelRunner extends \Illuminate\Testing\ParallelRunner
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     */
    protected function createApplication()
    {
        $applicationCreator = new class {
            use Traits\CreatesApplication;
        };

        return $applicationCreator->createApplication();
    }
}
