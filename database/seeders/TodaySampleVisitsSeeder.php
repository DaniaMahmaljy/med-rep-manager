<?php

namespace Database\Seeders;

use App\Models\Representative;
use App\Models\Sample;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodaySampleVisitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $samples = Sample::where('quantity_available', '>', 0)
                       ->limit(20)
                       ->get();

        Representative::each(function ($representative) use ($samples) {
            $visits = Visit::factory()
                ->count(rand(1, 3))
                ->create([
                    'representative_id' => $representative->id,
                    'scheduled_at' => now()
                        ->setHour(rand(8, 17))
                        ->setMinute([0, 15, 30, 45][rand(0, 3)]),
                        'status' => rand(1,3)
                ]);

          foreach ($visits as $visit) {
            $selectedSamples = $samples->random(rand(1, 3));

            foreach ($selectedSamples as $sample) {
                $pivotStatus =$visit->status;

                $visit->samples()->attach($sample->id, [
                    'quantity_assigned' => rand(1, min(3, $sample->quantity_assigned)),
                    'status' => $pivotStatus->value,
                    'created_at' => $visit->scheduled_at,
                    ]);
                }
            }
        });
    }
}
