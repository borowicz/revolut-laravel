<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_04_091306_create_scheduler_stats_table.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'scheduler_stats';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->dateTime('when')->nullable();
            $table->string('name')->default('');
            $table->integer('imported')->default(0);
            $table->integer('skipped')->default(0);
            $table->integer('new')->default(0);
            $table->integer('errors')->default(0);

            $table->datetimes();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
