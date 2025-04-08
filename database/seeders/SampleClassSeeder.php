<?php

namespace Database\Seeders;

use App\Models\SampleClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SampleClass::factory()->times(50)->create();

    }
}
