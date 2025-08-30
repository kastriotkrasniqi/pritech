<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $issues = \App\Models\Issue::factory(30)->create();
        $tags = \App\Models\Tag::all();
        $users = \App\Models\User::all();

        foreach ($issues as $issue) {
            // Attach 1-3 random tags if available
            if ($tags->count() > 0) {
                $issue->tags()->attach($tags->random(min($tags->count(), random_int(1, 3)))->pluck('id')->toArray());
            }
            // Attach 1-3 random users as members if available
            if ($users->count() > 0) {
                $issue->members()->attach($users->random(min($users->count(), random_int(1, 3)))->pluck('id')->toArray());
            }
        }
    }
}
