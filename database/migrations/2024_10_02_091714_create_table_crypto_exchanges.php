<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_02_091714_create_table_crypto_exchanges.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'crypto_exchanges';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->string('source');
            $table->string('hash');
            $table->date('when');
            $table->string('currency', 10); // USD, EUR, PLN
            $table->string('code', 10);
            $table->decimal('exchange_rate', 14, 6);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
