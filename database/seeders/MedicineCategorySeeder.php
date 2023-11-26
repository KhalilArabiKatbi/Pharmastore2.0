<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicineCategory;

class MedicineCategorySeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$this->call(MedicineCategorySeeder::class);

        MedicineCategory::create([
            'name' => 'sedative',
        ]);

        MedicineCategory::create([
            'name' => 'pain_killer',
        ]);

        MedicineCategory::create([
            'name' => 'antibiotic',
        ]);
        MedicineCategory::create([
            'name' => 'stimulant',
        ]);    }
}
