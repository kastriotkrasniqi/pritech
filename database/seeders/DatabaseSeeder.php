<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optionally seed users
        User::factory()->create([
            'name' => 'kastriot',
            'email' => 'krasniqikastriot01@gmail.com',
            'password' => bcrypt('password'), // password
        ]);

        $this->call([
            ProjectSeeder::class,
            TagSeeder::class,
            IssueSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
