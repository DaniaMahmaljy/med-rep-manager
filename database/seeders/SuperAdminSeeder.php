<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        if (User::where('email',  env('SUPERADMIN_EMAIL'))->exists()) {
            return;
        }

        $admin = Admin::create();

        $user = User::Create(
            [
                'first_name' => 'Dania',
                'last_name' => 'Mahmaljy',
                'username' => 'daniamahmaljy',
                'email' => env('SUPERADMIN_EMAIL'),
                'email_verified_at' => now(),
                'password_changed_at' => now(),
                'password' => Hash::make(env('SUPERADMIN_INITIAL_PASSWORD')),
                'remember_token' => Str::random(10),
            ]
            );
            $user->userable()->associate($admin);
            $user->save();
            $user->assignRole('superadmin');
    }
}
