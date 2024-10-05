<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_03_091822_create_table_commodities_transactions_values
 */
return new class extends Migration {
    private const TABLE_NAME = 'commodities_transaction_values';
    private const TABLE_RELATED = 'commodities_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash');

            // Foreign key relation to commodities_transactions table based on 'hash'
            $table->foreign('hash')
                ->references('hash')
                ->on(self::TABLE_RELATED)
                ->onDelete('cascade');

            // Columns for price and traded value
            $table->decimal('price', 14, 6)->nullable();
            $table->decimal('traded_value', 14, 6)->nullable();
            $table->string('currency')->nullable();

            // Timestamps and SoftDeletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
