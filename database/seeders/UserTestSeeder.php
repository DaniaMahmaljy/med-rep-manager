<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\City;
use App\Models\Municipal;
use App\Models\Representative;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Str;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::whereIn('email', [
            'super_admin@example.com',
            'admin@example.com',
            'supervisor@example.com',
            'representative@example.com',
        ])->forceDelete();

        $superAdmin = Admin::create();

        $userSuper = User::Create(
            [
                'first_name' => 'Jessy',
                'last_name' => 'Stark',
                'username' => 'superadmin',
                'email' => 'super_admin@example.com',
                'email_verified_at' => now(),
                'password_changed_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
         );
        $userSuper->userable()->associate($superAdmin);
        $userSuper->save();
        $userSuper->assignRole('superadmin');


        $admin = Admin::create();

        $userAdmin = User::Create(
            [
                'first_name' => 'Davin',
                'last_name' => 'Will',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password_changed_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
            );
            $userAdmin->userable()->associate($admin);
            $userAdmin->save();
            $userAdmin->assignRole('admin');


         $city = City::first();
         $municipal = Municipal::first();

        $supervisor = Supervisor::create(['city_id' => $city->id]);

        $userSupervisor = User::Create(
            [
                'first_name' => 'Hane',
                'last_name' => 'Will',
                'username' => 'supervisor',
                'email' => 'supervisor@example.com',
                'email_verified_at' => now(),
                'password_changed_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
            );
            $userSupervisor->userable()->associate($supervisor);
            $userSupervisor->save();
            $userSupervisor->assignRole('supervisor');


        $representative = Representative::create([
            'municipal_id' => $municipal->id,
            'supervisor_id' => $supervisor->id,
            'address' => 'Al-Mazzeh, Damascus, Syria',
            'latitude' => 33.513805,
            'longitude' => 36.276528,

        ]);

        $userRepresentative = User::Create(
            [
                'first_name' => 'Cynthia',
                'last_name' => 'Will',
                'username' => 'representative',
                'email' => 'representative@example.com',
                'email_verified_at' => now(),
                'password_changed_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
            );
            $userRepresentative->userable()->associate($representative);
            $userRepresentative->save();
            $userRepresentative->assignRole('representative');
    }
}
