<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\ApplicationVersion;

class ApplicationVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationVersion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'release' => fake()->date(),
            'end_of_life' => fake()->date(),
            'description' => fake()->text(),
            'application_id' => Application::factory(),
        ];
    }
}
