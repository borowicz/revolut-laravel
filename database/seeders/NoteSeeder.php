<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Note;

/**
 * - -***
 * php artisan db:seed --class=NoteSeeder
 */
class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $entry = [
            'title' => 'Welcome in Revolut Laravel',
            'content' => '...',
            'user_id' => 1,
        ];
        DB::table('notes')->insert($entry);

        Note::factory(10)->create(['user_id' => 1]);
    }
}
