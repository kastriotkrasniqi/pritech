<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

final class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(IssueStatus::all()),
            'priority' => $this->faker->randomElement(IssuePriority::all()),
            'due_date' => $this->faker->optional()->date(),
        ];
    }
}
