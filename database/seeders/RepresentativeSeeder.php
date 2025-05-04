<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Municipal;
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
        $cities = City::with('municipals')->get();

        Representative::factory()
            ->count(15)
            ->has(
                User::factory()->afterCreating(function (User $user) {
                    $user->assignRole('representative');
                }),
                'user'
            )

            ->afterCreating(function($rep) use ($cities) {
                $city = $cities->random();
                $municipals = $city->municipals->pluck('id');
                $rep->workingMunicipals()->attach($municipals);
                $rep->update(['municipal_id' => $municipals->first()]);
            })

            ->create();
    }
}
