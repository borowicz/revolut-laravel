<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_02_091557_create_table_crypto_transactions.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'crypto_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash');

            $table->string('date');
            $table->string('symbol')->default('');
            $table->string('type')->default('');
            $table->decimal('quantity', 14, 6)->nullable();
            $table->decimal('price', 14, 6)->nullable();
            $table->decimal('value', 14, 6)->nullable();
            $table->string('fees')->default('');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
