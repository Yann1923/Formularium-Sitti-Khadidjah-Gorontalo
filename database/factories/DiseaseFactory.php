<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disease>
 */
class DiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'icd_code' => fake()->unique()->regexify('[A-Z][0-9]{2}\.[0-9]'),
            'category' => fake()->randomElement(['Infeksi', 'Kardiovaskular', 'Respirasi', 'Gastrointestinal']),
            'description' => fake()->sentence(),
            'symptoms' => fake()->sentence(),
            'causes' => fake()->sentence(),
            'risk_factors' => fake()->sentence(),
            'diagnosis' => fake()->sentence(),
            'treatment' => fake()->sentence(),
            'prevention' => fake()->sentence(),
            'complications' => fake()->sentence(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
