<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\Integration;

class IntegrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Integration::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'integrates_with_id' => Application::factory(),
            'description' => fake()->text(),
            'protocol' => fake()->word(),
            'direction' => fake()->randomElement(["sync","inbound","outbound"]),
            'frequency' => fake()->randomElement(["realtime","daily","weekly","monthly","yearly"]),
            'security' => fake()->text(),
        ];
    }
}
