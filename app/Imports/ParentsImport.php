<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ParentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'nip'       => $row['nip'],
            'fullname'  => $row['fullname'],
            'email'     => $row['email'],
            'username'  => $row['username'],
            'password'  => Hash::make($row['password']),
            'level'     => $row['level'],
            'photo'     => $row['photo'] ?? null, // Foto bisa dikosongkan
        ]);
    }
}

