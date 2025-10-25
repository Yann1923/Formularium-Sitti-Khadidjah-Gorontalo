<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disease;
use App\Models\Medicine;

class DiseaseSeeder extends Seeder
{
    public function run()
    {
        $csvFile = database_path('seeders/data/diseases-full.csv');
        $csv = array_map('str_getcsv', file($csvFile));
        $headers = array_shift($csv);
        
        $diseases = array_map(function($row) use ($headers) {
            $disease = array_combine($headers, $row);
            $disease['medicines'] = json_decode($disease['medicines'], true);
            return $disease;
        }, $csv);

        foreach ($diseases as $disease) {
            $medicines = $disease['medicines'] ?? [];
            unset($disease['medicines']);
            
            $diseaseModel = Disease::create($disease);
            
            foreach ($medicines as $medicine) {
                $diseaseModel->medicines()->attach($medicine['id'], [
                    'dosage' => $medicine['dosage'],
                    'notes' => $medicine['notes']
                ]);
            }
        }
    }
}