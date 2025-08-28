<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
	protected $model = Project::class;

	public function definition()
	{
		return [
			'user_id' => User::factory(),
			'name' => $this->faker->sentence(3),
			'description' => $this->faker->paragraph(),
			'start_date' => $this->faker->date(),
			'deadline' => $this->faker->date(),
		];
	}
}
