<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090656_create_table_stock_markets.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_markets';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->integer('disabled')->default(1);

            $table->string('name'); // Stock market name (e.g., NYSE, NASDAQ)
            $table->string('short_name')->default(''); // Stock market name (e.g., NYQ, NSQ)

            $table->string('symbol')->nullable();

            $table->string('suffix', 10)->nullable();

            $table->string('suffix_gf', 10)->nullable()->comment('google finance');
//            $table->string('suffix_yf', 10)->nullable()->comment('yahoo finance');
            $table->string('suffix_ft', 10)->nullable()->comment('financial times');
            $table->string('suffix_bb', 10)->nullable()->comment('blomberg');
//            $table->string('suffix_cn', 10)->nullable()->comment('cnn');

            $table->string('country')->nullable();
            $table->string('currency')->nullable();

            $table->text('description')->default('');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
