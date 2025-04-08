<?php

namespace Database\Factories;

use App\Enums\VisitStatusEnum;
use App\Models\Doctor;
use App\Models\Representative;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'representative_id' => Representative::inRandomOrder()->first()?->id ?? Representative::factory()->create()->id,
            'doctor_id' => Doctor::inRandomOrder()->first()?->id ?? Doctor::factory()->create()->id,
            'status' => $this->faker->randomElement(VisitStatusEnum::cases())->value,
            'scheduled_at' => $this->faker->dateTime,
        ];
    }
}
