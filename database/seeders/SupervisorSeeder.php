<?php

namespace Database\Seeders;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Supervisor::factory()
            ->count(15)
            ->has(
                User::factory()->afterCreating(function (User $user) {
                    $user->assignRole('supervisor');
                }),
                'user'
            )
            ->create();
    }
}
