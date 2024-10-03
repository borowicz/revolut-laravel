<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * ddev exec ./artisan db:seed --class=DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'revolut',
            'email' => 'revolut@revolut-laravel.ddev.site ',
            'password' => Hash::make('csv'),
        ]);
    }
}
