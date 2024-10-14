<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_091033_create_table_currencies.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'currencies';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->integer('disabled')->default(0);
            $table->string('currency_code')->unique(); // USD, EUR, PLN
            $table->string('name');
            $table->string('symbol')->default('');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
