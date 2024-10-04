<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_04_091306_create_scheduler_logs_table.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'scheduler_logs';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->integer('cnt')->default(0);
            $table->dateTime('last_run')->nullable();
            $table->string('task_name')->default('')->unique();
            $table->longText('log')->default('');

            $table->datetimes();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
