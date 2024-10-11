<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *- -***
 * @example
 * php artisan migrate:refresh --path=./database/migrations/2024_10_05_110916_create_table_news_feeds.php
 */
return new class extends Migration {
    private const TABLE_NAME = 'news_feeds';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->integer('disabled')->default(0);
            $table->integer('keep')->default(0);
            $table->string('hash')->unique();
            $table->string('date')->nullable();
            $table->string('title')->nullable();
            $table->string('ticker')->default('');
            $table->string('type')->default('');
            $table->string('note')->nullable();
            $table->text('feed_url')->unique();
            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
