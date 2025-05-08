<?php

namespace Database\Seeders;

use App\Models\Sample;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = Sample::all();
        $specialties = Specialty::all();

        foreach ($samples as $sample) {
            $randomSpecialties = $specialties->random(rand(1, 3))->pluck('id')->toArray();

            $sample->specialties()->attach($randomSpecialties);

        }
    }
}
