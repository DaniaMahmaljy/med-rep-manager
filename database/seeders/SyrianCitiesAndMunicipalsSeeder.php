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
            [
                'en' => 'Damascus',
                'ar' => 'دمشق',
                'municipals' => [
                    ['en' => 'Al-Mazzah', 'ar' => 'المزة'],
                    ['en' => 'Abu Rummaneh', 'ar' => 'أبو رمانة'],
                    ['en' => 'Baramkeh', 'ar' => 'برامكة'],
                    ['en' => 'Kafr Sousa', 'ar' => 'كفر سوسة'],
                    ['en' => 'Muhajireen', 'ar' => 'المهاجرين'],
                    ['en' => 'Rukn al-Din', 'ar' => 'ركن الدين'],
                    ['en' => 'Mezzeh 86', 'ar' => 'مزة 86'],
                    ['en' => 'Al-Qanawat', 'ar' => 'القنوات'],
                    ['en' => 'Bab Tuma', 'ar' => 'باب توما'],
                    ['en' => 'Al-Midan', 'ar' => 'الميدان'],
                    ['en' => 'Al-Shaghour', 'ar' => 'الشاغور'],
                    ['en' => 'Al-Qassaa', 'ar' => 'القصاع'],
                    ['en' => 'Dummar', 'ar' => 'دمّر'],
                    ['en' => 'Al-Hajar al-Aswad', 'ar' => 'الحجر الأسود'],
                    ['en' => 'Tishreen', 'ar' => 'تشرين']
                ]
            ],
            [
                'en' => 'Aleppo',
                'ar' => 'حلب',
                'municipals' => [
                    ['en' => 'Al-Sulaymaniyah', 'ar' => 'السليمانية'],
                    ['en' => 'Al-Jamiliyah', 'ar' => 'الجاملية'],
                    ['en' => 'Al-Sakhour', 'ar' => 'الصاخور'],
                    ['en' => 'Bab al-Nairab', 'ar' => 'باب النيرب'],
                    ['en' => 'Old Aleppo', 'ar' => 'حلب القديمة']
                ]
            ],
            [
                'en' => 'Homs',
                'ar' => 'حمص',
                'municipals' => [
                    ['en' => 'Al-Waer', 'ar' => 'الوعر'],
                    ['en' => 'Al-Ghouta', 'ar' => 'الغوطة'],
                    ['en' => 'Al-Hamra', 'ar' => 'الحمراء'],
                    ['en' => 'Al-Mahatta', 'ar' => 'المحطة'],
                    ['en' => 'Bab al-Sebaa', 'ar' => 'باب السباع']
                ]
            ],
            [
                'en' => 'Hama',
                'ar' => 'حماة',
                'municipals' => [
                    ['en' => 'Al-Hamidiyah', 'ar' => 'الحامدية'],
                    ['en' => 'Al-Merj', 'ar' => 'المرج'],
                    ['en' => 'Bab al-Qubli', 'ar' => 'باب القبلي'],
                    ['en' => 'Al-Hader', 'ar' => 'الحاضر'],
                    ['en' => 'Al-Baath', 'ar' => 'البعث']
                ]
            ],
            [
                'en' => 'Latakia',
                'ar' => 'اللاذقية',
                'municipals' => [
                    ['en' => 'Al-Aziziyeh', 'ar' => 'العزيزية'],
                    ['en' => 'Al-Sinaa', 'ar' => 'الصناعة'],
                    ['en' => 'Al-Qusoor', 'ar' => 'القصور'],
                    ['en' => 'Al-Yarmouk', 'ar' => 'اليرموك']
                ]
            ],
            [
                'en' => 'Deir ez-Zor',
                'ar' => 'دير الزور',
                'municipals' => [
                    ['en' => 'Al-Joura', 'ar' => 'الجورة'],
                    ['en' => 'Al-Qusour', 'ar' => 'القصور'],
                    ['en' => 'Al-Rashidiyah', 'ar' => 'الرشيدية'],
                    ['en' => 'Al-Hamidiyah', 'ar' => 'الحميدية']
                ]
            ],
            [
                'en' => 'Al-Hasakah',
                'ar' => 'الحسكة',
                'municipals' => [
                    ['en' => 'Al-Aziziyah', 'ar' => 'العزيزية'],
                    ['en' => 'Al-Matar', 'ar' => 'المطار'],
                    ['en' => 'Al-Nasra', 'ar' => 'الناصرة'],
                    ['en' => 'Gweiran', 'ar' => 'غويران']
                ]
            ],
            [
                'en' => 'Raqqa',
                'ar' => 'الرقة',
                'municipals' => [
                    ['en' => 'Al-Mashlab', 'ar' => 'المشلب'],
                    ['en' => 'Al-Rawda', 'ar' => 'الروضة'],
                    ['en' => 'Al-Senaa', 'ar' => 'الصناعة'],
                ]
            ],
            [
                'en' => 'Daraa',
                'ar' => 'درعا',
                'municipals' => [
                    ['en' => 'Al-Sad Road', 'ar' => 'طريق السد'],
                    ['en' => 'Al-Manshiya', 'ar' => 'المنشية'],
                    ['en' => 'Al-Jumhuriya', 'ar' => 'الجمهورية'],
                    ['en' => 'Al-Kashef', 'ar' => 'الكاشف']
                ]
            ],
            [
                'en' => 'Idlib',
                'ar' => 'إدلب',
                'municipals' => [
                    ['en' => 'Al-Dabit', 'ar' => 'الضابط'],
                    ['en' => 'Al-Hamidiya', 'ar' => 'الحميدية'],
                    ['en' => 'Al-Qusoor', 'ar' => 'القصور'],
                    ['en' => 'Al-Mastumah', 'ar' => 'المسطومة']
                ]
            ],
            [
                'en' => 'Tartus',
                'ar' => 'طرطوس',
                'municipals' => [
                    ['en' => 'Al-Sahel', 'ar' => 'الساحل'],
                    ['en' => 'Al-Mina', 'ar' => 'المينا'],
                    ['en' => 'Al-Qalaa', 'ar' => 'القلعة'],
                    ['en' => 'Al-Raml', 'ar' => 'الرمل']
                ]
            ],
            [
                'en' => 'Al-Suwayda',
                'ar' => 'السويداء',
                'municipals' => [
                    ['en' => 'Al-Thawra', 'ar' => 'الثورة'],
                    ['en' => 'Al-Mazraa', 'ar' => 'المزرعة'],
                    ['en' => 'Al-Sir', 'ar' => 'السير'],
                    ['en' => 'Al-Karam', 'ar' => 'الكرم']
                ]
            ],
            [
                'en' => 'Quneitra',
                'ar' => 'القنيطرة',
                'municipals' => [
                    ['en' => 'Al-Baath', 'ar' => 'البعث'],
                    ['en' => 'Al-Samadaniyah', 'ar' => 'الصمدانية'],
                    ['en' => 'Al-Rafid', 'ar' => 'الرفيد'],
                    ['en' => 'Al-Hurriyah', 'ar' => 'الحرية']
                ]
            ],
            [
                'en' => 'Rif Dimashq',
                'ar' => 'ريف دمشق',
                'municipals' => [
                    ['en' => 'Douma', 'ar' => 'دوما'],
                    ['en' => 'Harasta', 'ar' => 'حرستا'],
                    ['en' => 'Erbin', 'ar' => 'عربين'],
                    ['en' => 'Jaramana', 'ar' => 'جرمانا'],
                    ['en' => 'Zabadani', 'ar' => 'الزبداني']
                ]
            ]
        ];

        foreach ($data as $cityData) {
            $city = new City();
            $city->translateOrNew('en')->name = $cityData['en'];
            $city->translateOrNew('ar')->name = $cityData['ar'];
            $city->save();

            foreach ($cityData['municipals'] as $municipalData) {
                $municipal = new Municipal();
                $municipal->city_id = $city->id;
                $municipal->translateOrNew('en')->name = $municipalData['en'];
                $municipal->translateOrNew('ar')->name = $municipalData['ar'];
                $municipal->save();
            }
        }
    }
}
