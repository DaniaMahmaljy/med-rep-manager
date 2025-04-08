<?php

namespace Database\Seeders;

use App\Models\Representative;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Representative::factory()->times(15)->has(User::factory(), 'user')->create();

    }
}
