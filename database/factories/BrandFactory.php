<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
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
