<?php

namespace Database\Factories;

use App\Models\CveQuery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CveQuery>
 */
class CveQueryFactory extends Factory
{
    protected $model = CveQuery::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'vendor' => fake()->randomElement(['microsoft', 'apache', 'linux', 'google', null]),
            'product' => fake()->randomElement(['windows', 'httpd', 'kernel', 'chrome', null]),
            'search' => fake()->optional()->word(),
            'weakness' => fake()->optional()->regexify('CWE-[0-9]{2,4}'),
            'tag' => fake()->optional()->word(),
            'cvss_threshold' => fake()->randomFloat(1, 5.0, 9.0),
            'notification_emails' => [fake()->email()],
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the query is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Set a specific CVSS threshold.
     */
    public function withThreshold(float $threshold): static
    {
        return $this->state(fn (array $attributes) => [
            'cvss_threshold' => $threshold,
        ]);
    }

    /**
     * Set specific notification emails.
     */
    public function withEmails(array $emails): static
    {
        return $this->state(fn (array $attributes) => [
            'notification_emails' => $emails,
        ]);
    }

    /**
     * Set specific vendor.
     */
    public function forVendor(string $vendor): static
    {
        return $this->state(fn (array $attributes) => [
            'vendor' => $vendor,
        ]);
    }

    /**
     * Set specific product.
     */
    public function forProduct(string $product): static
    {
        return $this->state(fn (array $attributes) => [
            'product' => $product,
        ]);
    }

    /**
     * Set both vendor and product.
     */
    public function forVendorProduct(string $vendor, string $product): static
    {
        return $this->state(fn (array $attributes) => [
            'vendor' => $vendor,
            'product' => $product,
        ]);
    }
}
