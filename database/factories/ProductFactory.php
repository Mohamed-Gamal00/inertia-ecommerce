<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => fake()->words(3, true),
            'name_en'      => fake()->optional()->words(3, true),
            'description'  => fake()->optional()->sentence(),
            'image'        => null,
            'price'        => fake()->randomFloat(2, 10, 1000),
            'discount_price' => null,
            'status'       => 'active',
            'quantity'     => fake()->numberBetween(5, 100),
            'is_special'   => false,
            'weight'       => fake()->optional()->randomFloat(2, 0.1, 5),
        ];
    }

    /**
     * Set a specific stock quantity.
     */
    public function stock(int $quantity): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $quantity,
        ]);
    }

    /**
     * Mark the product as out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
            'status'   => 'archived',
        ]);
    }
}
