<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'school_id' => 'CN.KBTK',
                'school_name' => 'KB-TK Islam Dian Didaktika',
                'region' => 'Depok',
                'address' => 'Jl. Rajawali Blok F, No. 10 & 16, Cinere, Depok, Jawa Barat. Kodepos 16512',
                'email' => 'kbtk@diandidaktika.sch.id',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        School::insert($schools);
    }
}
