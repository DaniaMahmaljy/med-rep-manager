<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()
            ->count(15)
            ->has(
                User::factory()->afterCreating(function (User $user) {
                    $user->assignRole('admin');
                }),
                'user'
            )
            ->create();
    }
}
