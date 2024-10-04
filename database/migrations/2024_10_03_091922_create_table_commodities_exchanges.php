<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_03_091922_create_table_commodities_exchanges.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'commodities_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash');

            $table->string('source');
            $table->string('hash');
            $table->date('when');
            $table->string('currency', 10); // USD, EUR, PLN
            $table->string('product', 10);
            $table->decimal('exchange_rate', 14, 6);


            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
