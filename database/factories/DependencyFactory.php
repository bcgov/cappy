<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\Dependency;

class DependencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dependency::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'supporting_application_id' => Application::factory(),
            'depending_application_id' => Application::factory(),
            'description' => fake()->text(),
        ];
    }
}
