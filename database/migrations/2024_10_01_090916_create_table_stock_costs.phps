<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_01_090916_create_table_stock_costs.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_costs';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            //
            // PDF
            //
            //Account value US
            //Account name
            //Accountount number
            //
            // Costs and Charges Related to Investment Services PDFs
            //  Type of Cost / Charge | RSEUAB | EUR | Total in PLN | Notes
            //
            // Costs and Charges Related to Financial Instruments
            //  Type of Cost / Charge | RSEUAB | Local Currency | Notes
            //
            // Totals
            //  Type of Cost / Charge | RSEUAB | Local Currency | Notes

            $table->timestamps();

            $table->comment('Costs and Charges Report');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
