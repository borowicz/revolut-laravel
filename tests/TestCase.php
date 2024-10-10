<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
//        putenv('APP_ENV=testing');
//        dd(getenv('APP_ENV'));
//        env('APP_ENV', 'testing');
//        dd('test');
//        dd('APP_ENV: ' . env('APP_ENV'));
        parent::setUp();

        Artisan::call('migrate:fresh --seed');
    }

//    public function getTable(mixed $model)
//    {
////        if (class_exists($model)) {
//            return (new $model())->getTable();
////        }
//
//        throw new \Exception('Model not found');
//    }
}
