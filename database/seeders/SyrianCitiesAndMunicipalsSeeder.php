<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Municipal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SyrianCitiesAndMunicipalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Damascus' => ['Al-Mazzah', 'Abu Rummaneh', 'Baramkeh', 'Kafr Sousa', 'Muhajireen', 'Rukn al-Din', 'Mezzeh 86', 'Al-Qanawat', 'Bab Tuma', 'Al-Midan','Al-Shaghour','Al-Qassaa','Dummar','Al-Hajar al-Aswad','Tishreen'],
            'Aleppo' => ['Al-Sulaymaniyah', 'Al-Jamiliyah', 'Al-Sakhour', 'Bab al-Nairab', 'Old Aleppo'],
            'Homs' => ['Al-Waer', 'Al-Ghouta', 'Al-Hamra', 'Al-Mahatta', 'Bab al-Sebaa'],
            'Hama' => ['Al-Hamidiyah', 'Al-Merj', 'Bab al-Qubli', 'Al-Hader', 'Al-Baath'],
            'Latakia' => ['Al-Assad', 'Al-Aziziyeh', 'Al-Sinaa', 'Al-Qusoor', 'Al-Yarmouk'],
            'Deir ez-Zor' => ['Al-Joura', 'Al-Qusour', 'Al-Rashidiyah', 'Al-Hamidiyah'],
            'Al-Hasakah' => ['Al-Aziziyah', 'Al-Matar', 'Al-Nasra', 'Gweiran'],
            'Raqqa' => ['Al-Mashlab', 'Al-Rawda', 'Al-Senaa', 'Al-Thakana'],
            'Daraa' => ['Al-Sad Road', 'Al-Manshiya', 'Al-Jumhuriya', 'Al-Kashef'],
            'Idlib' => ['Al-Dabit', 'Al-Hamidiya', 'Al-Qusoor', 'Al-Mastumah'],
            'Tartus' => ['Al-Sahel', 'Al-Mina', 'Al-Qalaa', 'Al-Raml'],
            'Al-Suwayda' => ['Al-Thawra', 'Al-Mazraa', 'Al-Sir', 'Al-Karam'],
            'Quneitra' => ['Al-Baath', 'Al-Samadaniyah', 'Al-Rafid', 'Al-Hurriyah'],
            'Rif Dimashq' => ['Douma', 'Harasta', 'Erbin', 'Jaramana', 'Zabadani']
        ];

        foreach ($data as $city => $municipals) {
            $city = City::firstOrCreate(['name' => $city]);

            foreach ($municipals as $name) {
                Municipal::firstOrCreate([
                    'city_id' => $city->id,
                    'name' => $name
                ]);
            }
        }
    }
}
