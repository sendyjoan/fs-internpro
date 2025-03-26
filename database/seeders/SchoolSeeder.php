<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('name', 'Administrator')->get();
        $smk1 = School::create([
            'name' => 'SMKN 1 Trenggalek',
            'email' => 'admin@smk1trenggalek.ac.id',
            'phone' => '081222333444',
            'address' => 'Trenggalek',
            'contact' => 'Bu Mariska',
            'created_by' => $admin->id
        ]);
    }
}
