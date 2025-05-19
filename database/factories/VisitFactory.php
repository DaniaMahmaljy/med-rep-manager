<?php

namespace Database\Factories;

use App\Enums\VisitStatusEnum;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\Supervisor;
use App\Models\User;
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
         $status = $this->faker->randomElement(VisitStatusEnum::cases());
        return [
            'representative_id' => Representative::inRandomOrder()->first()?->id ?? Representative::factory()->create()->id,
            'doctor_id' => Doctor::inRandomOrder()->first()?->id ?? Doctor::factory()->create()->id,
            'created_by' => User::where('userable_type', Supervisor::class) ->inRandomOrder()->first()?->id ?? User::factory()->create([
              'userable_id' => Supervisor::factory(),
              'userable_type' => Supervisor::class,])->id,
            'status' => $this->faker->randomElement(VisitStatusEnum::cases())->value,
            'scheduled_at' => $this->faker->dateTimeBetween('-30 days', '+30 days'),
            'status' => $status->value,
            'scheduled_at' => $this->faker->dateTimeBetween('-30 days', '+30 days'),
            'actual_visit_time' => $status === VisitStatusEnum::COMPLETED ? $this->faker->dateTimeBetween('-30 days', 'now') : null,
        ];
    }
}
