<?php

namespace Database\Factories;

use App\Enums\NoteTypeEnum;
use App\Models\Representative;
use App\Models\Supervisor;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notes>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visit_id' => Visit::inRandomOrder()->first()?->id ?? Visit::factory()->create()->id,
            'user_id' => User::whereIn('userable_type', [
                    Representative::class,
                    Supervisor ::class ])->inRandomOrder()->first()?->id,
            'content' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(NoteTypeEnum::cases())->value,
        ];
    }
}
