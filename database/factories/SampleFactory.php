<?php

namespace Database\Factories;

use App\Enums\SampleUnitEnum;
use App\Models\Brand;
use App\Models\SampleClass;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->unique()->name,
            'description' => $this->faker->sentence,
            'brand_id' => Brand::inRandomOrder()->first()?->id ?? Brand::factory()->create()->id,
            'sample_class_id' => SampleClass::inRandomOrder()->first()?->id ?? SampleClass::factory()->create()->id,
            'quantity_available' => $this->faker->numberBetween(10, 500),
            'unit' => $this->faker->randomElement(SampleUnitEnum::cases())->value,
            'expiration_date' => $this->faker->date,
        ];
    }
}
