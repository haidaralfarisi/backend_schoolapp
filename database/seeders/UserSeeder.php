<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nip' => '111',  // Sesuaikan dengan format NIP
            'fullname' => 'Super Admin',  // Pastikan pakai fullname, bukan name
            'username' => 'superadmin',
            'email' => 'superadmin@diandidaktika.sch.id',
            'password' => Hash::make('@Rajawali2025'), // Hash password agar aman
            'level' => 'SUPERADMIN', // Sesuaikan dengan sistem role yang kamu pakai
            'photo' => null, // Bisa diisi dengan URL foto jika ada
        ]);

        User::create([
            'nip' => '02.16.0270',
            'fullname' => 'Aida Soraya, S.S',
            'username' => 'aida',
            'email' => 'aida@diandidaktika.sch.id',
            'password' => Hash::make('Aida2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.16.0271',
            'fullname' => 'Gisca Hagarayu, S.Pd',
            'username' => 'gisca',
            'email' => 'gisca@diandidaktika.sch.id',
            'password' => Hash::make('Gisca2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.13.0218',
            'fullname' => 'Maisaroh, S.Pd',
            'username' => 'maisaroh',
            'email' => 'maisaroh@diandidaktika.sch.id',
            'password' => Hash::make('Maisaroh2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.17.0296',
            'fullname' => 'Nina Rosita, S.Pd',
            'username' => 'nina',
            'email' => 'nina@diandidaktika.sch.id',
            'password' => Hash::make('Nina2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.14.0227',
            'fullname' => 'Rizky Purnomo R, S.Pd',
            'username' => 'rama',
            'email' => 'rama@diandidaktika.sch.id',
            'password' => Hash::make('Rama2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.21.0334',
            'fullname' => 'Andri Maulani N, S.Pd',
            'username' => 'andri',
            'email' => 'andri@diandidaktika.sch.id',
            'password' => Hash::make('Andri2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.03.0103',
            'fullname' => 'Ari Herlina D, S.Pd.I',
            'username' => 'ari',
            'email' => 'ari@diandidaktika.sch.id',
            'password' => Hash::make('Ari2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.24.0384',
            'fullname' => 'Arini Ilma, S.Pd',
            'username' => 'arini',
            'email' => 'arini@diandidaktika.sch.id',
            'password' => Hash::make('Arini2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.23.0370',
            'fullname' => 'Asya Pricilla S, S.S',
            'username' => 'asya',
            'email' => 'Asya@diandidaktika.sch.id',
            'password' => Hash::make('Asya2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.22.0348',
            'fullname' => 'Chandra Sashi M, S.Pd',
            'username' => 'chandra',
            'email' => 'sashi@diandidaktika.sch.id',
            'password' => Hash::make('Sashi2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.23.0369',
            'fullname' => 'Dinda Ayu Mutiara, S.Pd',
            'username' => 'dinda',
            'email' => 'dinda@diandidaktika.sch.id',
            'password' => Hash::make('Dinda2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.07.0149',
            'fullname' => 'Enung Nurjanah, S.Pd.I.',
            'username' => 'enung',
            'email' => 'enung@diandidaktika.sch.id',
            'password' => Hash::make('Enung2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.08.0147',
            'fullname' => 'Larisa Zilfi D.H, S.Psi.',
            'username' => 'larisa',
            'email' => 'larisa@diandidaktika.sch.id',
            'password' => Hash::make('Larisa2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.98.0056',
            'fullname' => 'Rahayu Damayanti, S.Pd',
            'username' => 'rahayu',
            'email' => 'rahayu@diandidaktika.sch.id',
            'password' => Hash::make('Rahayu2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.21.0343',
            'fullname' => 'Riyan Agus S, S.Pd',
            'username' => 'riyan',
            'email' => 'riyan@diandidaktika.sch.id',
            'password' => Hash::make('Riyan2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.95.0041',
            'fullname' => 'Ruchi Konita, S.Pd.I.',
            'username' => 'ruchi',
            'email' => 'qori@diandidaktika.sch.id',
            'password' => Hash::make('Qori2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);

        User::create([
            'nip' => '02.11.0187',
            'fullname' => 'Sukriyati, S.Pd.I.',
            'username' => 'sukriyati',
            'email' => 'sukriyati@diandidaktika.sch.id',
            'password' => Hash::make('Sukriyati2025'),
            'level' => 'GURU',
            'photo' => null,
        ]);



        // User Orangtua
        User::create([
            // 'nip' => '02.24.0385',
            'fullname' => 'Budianto',
            // 'email' => 'alya@diandidaktika.sch.id',
            'username' => 'budianto',
            'password' => Hash::make('Budianto2025'),
            'level' => 'ORANGTUA',
            'photo' => null,
        ]);

        User::create([
            // 'nip' => '02.24.0385',
            'fullname' => 'Siti Nurjanah',
            // 'email' => 'alya@diandidaktika.sch.id',
            'username' => 'siti',
            'password' => Hash::make('Siti2025'),
            'level' => 'ORANGTUA',
            'photo' => null,
        ]);

        User::create([
            // 'nip' => '02.24.0385',
            'fullname' => 'Lina Marlina',
            // 'email' => 'alya@diandidaktika.sch.id',
            'username' => 'lina',
            'password' => Hash::make('Lina2025'),
            'level' => 'ORANGTUA',
            'photo' => null,
        ]);
    }
}
