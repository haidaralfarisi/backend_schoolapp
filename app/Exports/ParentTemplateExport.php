<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ParentTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['1234567890', 'Siti Aminah', 'aminah@gmail.com', 'aminah123', 'parent123', 'ORANGTUA', ''], // Foto bisa dikosongkan
        ];
    }

    public function headings(): array
    {
        return [
            'nip',
            'fullname',
            'email',
            'username',
            'password',
            'level',
            'photo',
        ];
    }
}
