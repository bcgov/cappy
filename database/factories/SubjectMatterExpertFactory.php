<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SubjectMatterExpert;

class SubjectMatterExpertFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubjectMatterExpert::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'affiliation_type' => fake()->regexify('[A-Za-z0-9]{400}'),
            'affiliation_id' => fake()->numberBetween(-10000, 10000),
            'email' => fake()->safeEmail(),
        ];
    }
}
