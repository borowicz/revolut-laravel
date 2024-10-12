<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090702_create_table_stock_tickers.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_tickers';
    private const TABLE_RELATED = 'stock_markets';

    public function up(): void
    {
//        $table->foreignId('stock_markets_id')->constrained()->default(null);
//            $table->foreign('stock_markets_id')
//                ->references('id')
//                ->on(self::TABLE_RELATED)
//                ->onDelete('cascade');
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_markets_id')->nullable();
            $table->foreign('stock_markets_id')
                ->references('id')
                ->on(self::TABLE_RELATED)
                ->onDelete('cascade')
                ->nullable();

            $table->integer('disabled')->default(0);
            $table->string('hash')->unique();

            $table->string('ticker')->unique();
            $table->string('url')->default('');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
