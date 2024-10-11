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
        $usersData = [
            [
                'name'     => 'cli',
                'email'    => 'cli@rl.local',
                'password' => Hash::make(Str::random(256)),
            ],
            [
                'name'     => 'revolut',
                'email'    => 'revolut@rl.local',
                'password' => Hash::make('csv'),
            ],
        ];
        foreach ($usersData as $user) {
            $userCheck = User::select()
                ->where('name', $user['name'])
                ->where('email', $user['email'])
                ->first();
            if (!$userCheck) {
                User::factory()->create($user);
            }
        }

        $this->call(NoteSeeder::class);
        $this->call(StockMarketSeeder::class);
    }
}
