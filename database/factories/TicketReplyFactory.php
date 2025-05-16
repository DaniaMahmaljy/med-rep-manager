<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketReply>
 */
class TicketReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'ticket_id' => Ticket::inRandomOrder()->first()?->id ?? Ticket::factory()->create()->id,
        'user_id' => User::inRandomOrder()->first()->id,
        'reply' => $this->faker->paragraph,
        ];
    }
}
