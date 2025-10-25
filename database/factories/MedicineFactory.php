<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
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
            'generic_name' => fake()->word(),
            'category' => fake()->randomElement(['Antibiotik', 'Analgesik', 'Antipiretik', 'Antiseptik']),
            'description' => fake()->sentence(),
            'dosage_form' => fake()->randomElement(['Tablet', 'Kapsul', 'Sirup', 'Salep']),
            'strength' => fake()->randomElement(['500mg', '250mg', '100mg']),
            'manufacturer' => fake()->company(),
            'price' => fake()->randomFloat(2, 1000, 100000),
            'expiry_date' => fake()->dateTimeBetween('+1 month', '+2 years'),
            'indications' => fake()->sentence(),
            'contraindications' => fake()->sentence(),
            'side_effects' => fake()->sentence(),
            'dosage_instructions' => fake()->sentence(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
