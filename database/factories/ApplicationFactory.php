<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{

    protected $model = Application::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'user_id' => User::factory(),
            'location_id' => Location::factory(),
            'description' => $this->faker->text,
            'type' => $this->faker->randomElement(['suggestion', 'complaint', 'request']),
            'source' => $this->faker->randomElement(['api', 'web']),
        ];
    }
}
