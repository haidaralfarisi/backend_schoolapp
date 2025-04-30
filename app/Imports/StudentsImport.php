<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Student([
            'student_id'    => $row['student_id'],
            'school_id'     => $row['school_id'],
            'class_id'      => $row['class_id'],
            'nisn'          => $row['nisn'],
            'fullname'     => $row['fullname'],
            'username'     => $row['username'],
            'gender'        => $row['gender'],
            'pob' => $row['pob'],
            'dob'          => $this->convertDate($row['dob']), // Panggil fungsi konversi
            'entry_year'    => $row['entry_year'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    private function convertDate($date)
{
    try {
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    } catch (\Exception $e) {
        return null; // Jika gagal, kosongkan nilai (bisa diubah sesuai kebutuhan)
    }
}
}
