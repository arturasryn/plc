<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $usersCount = 10;

        foreach(range(1, $usersCount) as $index) {
            User::factory()->create([
                'name' => "Test User $index",
                'email' => "test$index@example.com",
            ]);
        }

        Issue::factory()->state(function (array $attributes) use($usersCount) { 
            return [
                'user_id' => random_int(1, $usersCount),
                'performer_id' => random_int(1, $usersCount),
                'tester_id' => random_int(1, $usersCount),
            ];
        })->count(100)->create();
    }
}
