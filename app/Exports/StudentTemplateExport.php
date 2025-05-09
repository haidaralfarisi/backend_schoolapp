<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class StudentTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['2025CN.KBTK001', 'CN.KBTK', 'CN.KB1', '1234567890', '1234', 'Renata', 'Male', 'Depok', '14/03/2001', '2025', 'No image'],
        ];
    }

    public function headings(): array
    {
        return [
            'student_id',
            'school_id',
            'class_id',
            'nisn',
            'nis',
            'fullname',
            'gender',
            'pob',
            'dob',
            'entry_year',
            'image',
        ];
    }
}
