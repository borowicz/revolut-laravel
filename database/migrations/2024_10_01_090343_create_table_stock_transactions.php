<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090343_create_table_stock_transactions.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash');

            $table->string('date');
            $table->string('ticker')->default('');
            $table->string('type')->default('');
            $table->decimal('quantity', 14, 6)->nullable();
            $table->decimal('price_per_share', 14, 6)->nullable();
            $table->decimal('total_amount', 14, 6)->nullable();
            $table->string('currency')->default('');
            $table->decimal('fx_rate', 14, 6)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
