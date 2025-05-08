<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Sample;

class SampleService extends Service
{
    public function getSamplesByDoctorSpecialty(Doctor $doctor)
    {
         if (!$doctor->specialty_id) {
        return collect();
    }
    return Sample::whereHas('specialties', function($query) use ($doctor) {
        $query->where('specialty_id', $doctor->specialty_id);
    })->get();
}
}
