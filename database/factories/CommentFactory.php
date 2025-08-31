<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'issue_id' => Issue::factory(),
            'body' => $this->faker->paragraph(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
