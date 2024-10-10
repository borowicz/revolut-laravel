<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_03_101635_create_table_cash_transactions.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'cash_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash');

            $table->string('date');

            // Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
            $table->string('type')->nullable();
            $table->string('product')->nullable();
            $table->string('started_date')->nullable();
            $table->string('completed_date')->nullable();
            $table->string('description')->nullable();

            $table->string('amount_raw')->nullable();
            $table->decimal('amount', 14, 6)->nullable();
            $table->string('fee_raw')->nullable();
            $table->decimal('fee', 14, 6)->nullable();
            $table->string('currency')->nullable();

            $table->string('state')->nullable();
            $table->string('balance')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
