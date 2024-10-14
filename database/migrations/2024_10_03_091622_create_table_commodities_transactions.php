<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_03_091622_create_table_commodities_transactions.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'commodities_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique()->index();

            // Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
            $table->string('type')->default('');
            $table->string('product')->default('');
            $table->datetime('started_date')->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->string('description')->default('');

            $table->decimal('amount', 14, 6)->nullable();
            $table->string('amount_raw')->default('');

            $table->decimal('fee', 14, 6)->nullable();
            $table->string('fee_raw')->default('');

            $table->string('currency')->default('');
            $table->string('state')->default('');

            $table->decimal('balance', 14, 6)->nullable();
            $table->string('balance_raw')->default('');

            // Additional columns for price and traded value editable by user
            $table->string('note')->nullable();
            $table->decimal('price', 14, 6)->nullable();
            $table->decimal('traded_value', 14, 6)->nullable();
            $table->string('currency_exchange')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
