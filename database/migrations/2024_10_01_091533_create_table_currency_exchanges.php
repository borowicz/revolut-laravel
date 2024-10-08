<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_091533_create_table_currency_exchanges.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'currency_exchanges';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('source')->nullable();
            $table->string('hash')->unique();
            $table->date('date')->nullable();
            $table->string('currency', 5)->default(''); // USD, EUR, PLN
            $table->string('code', 10)->default(''); // code eg. EURUSD
            $table->decimal('exchange_rate', 14, 6); // rate eg. 1.234567 EURUSD

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
