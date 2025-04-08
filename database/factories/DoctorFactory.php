<?php

namespace Database\Factories;

use App\Models\Municipal;
use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'specialty_id' => Specialty::inRandomOrder()->first()?->id ?? Specialty::factory()->create()->id,
            'municipal_id' => Municipal::inRandomOrder()->first()?->id,
            'description' => $this->faker->sentence,
            'phone' => $this->faker->numerify('+9639#######'), // Syrian number
            'address' => $this->faker->address,
            // Somewhere in Syria
            'latitude' => $this->faker->latitude(32.0, 37.5),
            'longitude' => $this->faker->longitude(35.5, 42.0),
        ];
    }
}
