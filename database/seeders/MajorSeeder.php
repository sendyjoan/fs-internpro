<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') === 'local'){
            $sekolah = School::where('name', 'SMK Development')->first();

            $major = [
                [
                    'name' => 'Teknik Komputer dan Jaringan',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Rekayasa Perangkat Lunak',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Multimedia',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Desain Komunikasi Visual',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Bisnis Daring dan Pemasaran',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Akuntansi dan Keuangan Lembaga',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Usaha Perjalanan Wisata',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Perhotelan',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Perbankan Syariah',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Farmasi',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Agribisnis Pengolahan Hasil Pertanian',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Kendaraan Ringan Otomotif',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Sepeda Motor',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Gambar Bangunan',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Instalasi Tenaga Listrik',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Audio Video',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Pemesinan',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Konstruksi Batu dan Beton',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Konstruksi Kayu',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Pembangkit Energi Terbarukan',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Pengelasan',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Otomasi Industri',
                    'school_id' => $sekolah->id,
                ],
                [
                    'name' => 'Teknik Mekatronika',
                    'school_id' => $sekolah->id,
                ],
            ];

            foreach ($major as $m) {
                $m['code'] = Major::codeGenerator();
                Major::create($m);
            }
        }
    }
}
