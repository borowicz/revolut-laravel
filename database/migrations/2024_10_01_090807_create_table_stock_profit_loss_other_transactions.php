<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090807_create_table_stock_profit_loss_other_transactions.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_profit_loss_other_transactions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('hash')->nullable();

            $table->string('date')->nullable();            //Date
            $table->string('symbol')->nullable();          //Symbol
            $table->string('security_name')->nullable();   //Security name
            $table->string('isin')->nullable();            //ISIN
            $table->string('country')->nullable();         //Country
            $table->string('gross_amount')->nullable();    //Gross amount
            $table->string('withholding_tax')->nullable(); //Withholding tax
            $table->string('net_amount')->nullable();      //Net Amount
            $table->string('currency')->nullable();        //Currency

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
