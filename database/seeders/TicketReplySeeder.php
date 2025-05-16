<?php

namespace Database\Seeders;

use App\Models\TicketReply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketReply::factory()->count(50)->create();
    }
}
