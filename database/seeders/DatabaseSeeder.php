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
        $userData = [
            'name' => 'revolut',
            'email' => 'revolut@rl.local',
            'password' => Hash::make('csv'),
        ];
        $userCheck = User::select()
            ->where('name', $userData['name'])
            ->where('email', $userData['email'])
            ->first();
        if (!$userCheck) {
            User::factory()->create($userData);
        }

        $this->call(NoteSeeder::class);
        $this->call(StockMarketSeeder::class);
    }
}
