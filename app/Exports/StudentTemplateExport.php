<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class StudentTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['2025CNTK001', 'CNTK', 'CNTK1', '1234567890', 'Renata', 'renata', 'Male', 'Depok', '14/03/2001', '2023'],
        ];
    }

    public function headings(): array
    {
        return [
            'student_id',
            'school_id',
            'class_id',
            'nisn',
            'fullname',
            'username',
            'gender',
            'pob',
            'dob',
            'entry_year',
        ];
    }
}
