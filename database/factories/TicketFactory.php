<?php

namespace Database\Factories;

use App\Enums\TicketPriorityEnum;
use App\Enums\TicketStatusEnum;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $ticketableTypes = [
            Doctor::class,
            Visit::class,
            Representative::class,
            null,
        ];

        $ticketableType = $this->faker->randomElement($ticketableTypes);

        if ($ticketableType) {
            $ticketableId = $ticketableType::inRandomOrder()->first()->id ?? null;
        } else {
            $ticketableId = null;
        }

        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TicketStatusEnum::cases())->value,
            'priority' =>  $this->faker->randomElement(TicketPriorityEnum::cases())->value,
            'ticketable_type' => $ticketableType,
            'ticketable_id' => $ticketableId,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
