<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090907_create_table_stock_profit_loss_transactions.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_profit_loss_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash');

            $table->string('date_acquired')->nullable();    //Date acquired
            $table->string('date_sold')->nullable();        //Date sold
            $table->string('symbol')->nullable();           //Symbol
            $table->string('security_name')->nullable();    //Security name
            $table->string('isin')->nullable();             //ISIN
            $table->string('country')->nullable();          //Country
            $table->string('quantity')->nullable();         //Quantity
            $table->string('cost_basis')->nullable();       //Cost basis
            $table->string('gross_proceeds')->nullable();   //Gross proceeds
            $table->string('gross_pnl')->nullable();        //Gross PnL
            $table->string('currency')->nullable();         //Currency

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
