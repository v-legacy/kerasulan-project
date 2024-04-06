<?php

namespace Database\Seeders;

use App\Models\Recruitment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recruitment')->insert(
            [
                [
                    'nik' => fake()->uuid(),
                    'nama_lengkap' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'telp' => fake()->phoneNumber(),
                    'pekerjaan' => fake()->jobTitle(),
                    'alamat' => fake()->address(),
                    'umur' => fake()->numberBetween(18, 60),
                    'pendidikan' => fake()->city(),
                    'id_user' => 1,
                ],
                [
                    'nik' => fake()->uuid(),
                    'nama_lengkap' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'telp' => fake()->phoneNumber(),
                    'pekerjaan' => fake()->jobTitle(),
                    'alamat' => fake()->address(),
                    'umur' => fake()->numberBetween(18, 60),
                    'pendidikan' => fake()->city(),
                    'id_user' => 2,
                ],
                [
                    'nik' => fake()->uuid(),
                    'nama_lengkap' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'telp' => fake()->phoneNumber(),
                    'pekerjaan' => fake()->jobTitle(),
                    'alamat' => fake()->address(),
                    'umur' => fake()->numberBetween(18, 60),
                    'pendidikan' => fake()->city(),
                    'id_user' => 3,
                ],
                [
                    'nik' => fake()->uuid(),
                    'nama_lengkap' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'telp' => fake()->phoneNumber(),
                    'pekerjaan' => fake()->jobTitle(),
                    'alamat' => fake()->address(),
                    'umur' => fake()->numberBetween(18, 60),
                    'pendidikan' => fake()->city(),
                    'id_user' => 4,
                ],
                [
                    'nik' => fake()->uuid(),
                    'nama_lengkap' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'telp' => fake()->phoneNumber(),
                    'pekerjaan' => fake()->jobTitle(),
                    'alamat' => fake()->address(),
                    'umur' => fake()->numberBetween(18, 60),
                    'pendidikan' => fake()->city(),
                    'id_user' => 5,
                ],
                [
                    'nik' => fake()->uuid(),
                    'nama_lengkap' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'telp' => fake()->phoneNumber(),
                    'pekerjaan' => fake()->jobTitle(),
                    'alamat' => fake()->address(),
                    'umur' => fake()->numberBetween(18, 60),
                    'pendidikan' => fake()->city(),
                    'id_user' => 6,
                ]

            ]
        );
    }
}
