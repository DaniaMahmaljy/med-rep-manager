<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SyrianCitiesAndMunicipalsSeeder::class,
            RolePermissionSeeder::class,
            SuperAdminSeeder::class,
            UserTestSeeder::class,
            AdminSeeder::class,
            SpecialtySeeder::class,
            DoctorSeeder::class,
            SupervisorSeeder::class,
            RepresentativeSeeder::class,
            BrandSeeder::class,
            SampleClassSeeder::class,
            SampleSeeder::class,
            VisitSeeder::class,
            NoteSeeder::class,
            SampleSpecialtySeeder::class,
            TicketSeeder::class,
            TicketReplySeeder::class,
        ]);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
