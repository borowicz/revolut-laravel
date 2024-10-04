<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_04_091300_create_schedulers_table.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'schedulers';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->integer('hidden')->default(0);

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->string('run_at')->default('');

            $table->string('task_name')->default('');
            $table->string('description')->default('');

            $table->datetimes();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
