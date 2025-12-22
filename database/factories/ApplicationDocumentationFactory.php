<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\ApplicationDocumentation;
use App\Models\Documentation;

class ApplicationDocumentationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationDocumentation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'documentation_of_id' => Documentation::factory()->create()->of_id,
            'description' => fake()->text(),
        ];
    }
}
