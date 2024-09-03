<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationAssignment>
 */
class ApplicationAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $assignee = $this->faker->randomElement([User::factory(),Department::factory()]);
        return [
            'id' => $this->faker->uuid,
            'application_id' => Application::factory(),
            'assignee_id' => $assignee,
            'assignee_type' => $assignee->modelName(),
            'reason' => $this->faker->sentence,
        ];
    }
}
