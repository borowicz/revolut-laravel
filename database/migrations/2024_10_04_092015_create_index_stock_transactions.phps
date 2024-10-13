<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_04_091019_create_notes_table.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'stock_transactions';

    private $searchIndexes = ['ticker', 'when'];

    public function up(): void
    {
//        if(!Schema::hasTable(self::TABLE_NAME)) {
//            return;
//        }
//
//        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
//
//            foreach ($this->searchIndexes as $index) {
//                $table->index($index);
//            }
//        });
    }

    public function down(): void
    {
//        if (Schema::hasColumn(self::TABLE_NAME, [$this->searchIndexes])) {
//            Schema::table(self::TABLE_NAME, function (Blueprint $table) {
//                $table->dropIndex($this->searchIndexes);
//            });
//        }
    }
};
