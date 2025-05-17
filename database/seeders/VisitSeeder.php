<?php

namespace Database\Seeders;

use App\Enums\SampleVisitStatus;
use App\Models\Sample;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


         Visit::factory()
        ->count(50)
        ->create()
        ->each(function ($visit) {
        $samples = Sample::inRandomOrder()->take(3)->get();

        foreach ($samples as $sample) {
            $quantity = rand(1, 3);

            $visit->samples()->attach($sample->id, [
                'quantity_assigned' => $quantity,
                'quantity_used' => 0,
                'status' => SampleVisitStatus::PENDING->value,
            ]);

            $sample->decrement('quantity_available', $quantity);
        }
    });

    }
}
