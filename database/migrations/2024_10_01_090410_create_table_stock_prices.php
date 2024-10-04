<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090410_create_table_stock_prices.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_prices';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->string('source')->default('');
            $table->string('refreshed')->default('');
            $table->dateTime('day')->nullable();
            $table->string('ticker')->default('');
            $table->decimal('open', 8, 2)->nullable();
            $table->decimal('high', 8, 2)->nullable();
            $table->decimal('low', 8, 2)->nullable();
            $table->decimal('close', 8, 2)->nullable();
            $table->string('volume')->default('');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
