<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'category' => fake()->randomElement(["business","support","data","network","hosting","security","other"]),
            'average_daily_users' => fake()->numberBetween(-10000, 10000),
            'annual_cost' => fake()->numberBetween(-10000, 10000),
            'cost_function' => fake()->regexify('[A-Za-z0-9]{400}'),
            'cost_per_unit' => fake()->numberBetween(-10000, 10000),
            'license_summary' => fake()->text(),
            'annual_vendor_cost' => fake()->numberBetween(-10000, 10000),
            'initial_deployment' => fake()->date(),
            'end_of_support' => fake()->date(),
            'end_of_life' => fake()->date(),
            'disposition_deadline' => fake()->date(),
            'disposition_decision' => fake()->regexify('[A-Za-z0-9]{400}'),
        ];
    }
}
