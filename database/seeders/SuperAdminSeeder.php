<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'first_name' => 'Dania',
                'last_name' => 'Mahmaljy',
                'username' => 'daniamahmaljy',
                'email' => 'daniamahmaljy1@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Password123!'),
                'remember_token' => Str::random(10),
            ]
            );

            $user->assignRole('superadmin');
    }
}
