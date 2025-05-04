<?php

namespace Database\Factories;

use App\Enums\SampleUnitEnum;
use App\Models\Brand;
use App\Models\SampleClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sample>
 */
class SampleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerEn = FakerFactory::create('en_US');
        $fakerAr = FakerFactory::create('ar_SA');

        return [
            'brand_id' => Brand::inRandomOrder()->first()?->id ?? Brand::factory()->create()->id,
            'sample_class_id' => SampleClass::inRandomOrder()->first()?->id ?? SampleClass::factory()->create()->id,
            'quantity_available' => $this->faker->numberBetween(10, 500),
            'unit' => $this->faker->randomElement(SampleUnitEnum::cases())->value,
            'expiration_date' => Carbon::now()->addYear(),
            'en' => [
                'name' => $fakerEn->unique()->name,
                'description' => $fakerEn->sentence,
            ],
            'ar' => [
                'name' => $fakerAr->unique()->name,
                'description' => $fakerAr->sentence,
            ],
        ];
    }
}
