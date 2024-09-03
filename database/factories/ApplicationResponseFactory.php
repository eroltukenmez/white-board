<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationResponse>
 */
class ApplicationResponseFactory extends Factory
{
    protected $model = ApplicationResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'user_id' => User::factory(),
            'response_text' => $this->faker->paragraph,
            'response_type' => $this->faker->randomElement(['interim_response', 'note', 'final_response']),
        ];
    }
}
