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

            // Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
            $table->string('date');
            $table->string('type')->default('');
            $table->string('product')->default('');
            $table->string('started_date')->default('');
            $table->string('completed_date')->default('');
            $table->string('description')->default('');
            $table->decimal('amount', 14, 6)->nullable();
            $table->decimal('fee', 14, 6)->nullable();
            $table->decimal('currency', 14, 6)->nullable();
            $table->string('state')->default('');
            $table->string('balance')->default('');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
