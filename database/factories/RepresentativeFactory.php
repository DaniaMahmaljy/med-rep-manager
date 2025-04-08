<?php

namespace Database\Factories;

use App\Models\Municipal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Representative>
 */
class RepresentativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'municipal_id' => Municipal::inRandomOrder()->first()?->id,
            'address' => $this->faker->address,
            // Somewhere in Syria
            'latitude' => $this->faker->latitude(32.0, 37.5),
            'longitude' => $this->faker->longitude(35.5, 42.0),
        ];
    }
}
