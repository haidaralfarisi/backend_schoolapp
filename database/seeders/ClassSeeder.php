<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.KB1',
                'class_name' => 'KB 1',
                'grade' => 'KB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.KB2',
                'class_name' => 'KB 2',
                'grade' => 'KB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.KB3',
                'class_name' => 'KB 3',
                'grade' => 'KB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.TKA1',
                'class_name' => 'TK A1',
                'grade' => 'TKA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.TKA2',
                'class_name' => 'TK A2',
                'grade' => 'TKA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.TKA3',
                'class_name' => 'TK A3',
                'grade' => 'TKA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.TKB1',
                'class_name' => 'TK B1',
                'grade' => 'TKB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.TKB2',
                'class_name' => 'TK B2',
                'grade' => 'TKB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 'CN.KBTK',
                'class_id' => 'CN.TKB3',
                'class_name' => 'TK B3',
                'grade' => 'TKB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ClassModel::insert($classes);
    }
}
