<?php

namespace Tests\Console;

use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

it('initializes options and force correctly', function () {
    $command = new class extends \App\Console\AbstractCommand {
        public function options() {
            return ['force' => true];
        }
    };
    $command->init();
    expect($command->options)->toBe(['force' => true]);
    expect($command->force)->toBeTrue();
});

it('determines verbosity correctly', function () {
    $output = Mockery::mock(OutputInterface::class);
    $output->shouldReceive('getVerbosity')->andReturn(OutputInterface::VERBOSITY_DEBUG);
    $command = new class extends \App\Console\AbstractCommand {
        public function getOutput() {
            return $this->output;
        }
    };
    $command->setOutput($output);
    expect($command->getVerbosity())->toBeTrue();
});

it('gets summary with session data', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['imported' => 10]);
    $output = Mockery::mock(OutputInterface::class);
    $output->shouldReceive('getVerbosity')->andReturn(OutputInterface::VERBOSITY_VERBOSE);
    $output->shouldReceive('writeln')->with(Mockery::on(function ($arg) {
        return strpos($arg, 'results:') !== false;
    }));
    $command = new class extends \App\Console\AbstractCommand {
        public function getOutput() {
            return $this->output;
        }
    };
    $command->setOutput($output);
    $command->getSummary();
});

it('stores log when saveLog is true', function () {
    $command = Mockery::mock(\App\Console\AbstractCommand::class)->makePartial();
    $command->shouldReceive('storeLog')->once();
    $output = Mockery::mock(OutputInterface::class);
    $output->shouldReceive('getVerbosity')->andReturn(OutputInterface::VERBOSITY_VERBOSE);
    $command->setOutput($output);
    $command->getSummary(true, true);
});
