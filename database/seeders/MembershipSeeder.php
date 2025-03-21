<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Membership::create([
            'name' => 'Free',
            'price' => 0,
            'duration' => 30,
            'max_majors' => 1,
            'max_classes' => 1,
            'max_students' => 10,
            'max_partners' => 1,
            'max_mentors' => 1,
            'max_programs' => 1,
            'max_activities' => 1,
            'max_storages' => 1,
        ]);
        Membership::create([
            'name' => 'Basic',
            'price' => 10,
            'duration' => 30,
            'max_majors' => 2,
            'max_classes' => 2,
            'max_students' => 20,
            'max_partners' => 2,
            'max_mentors' => 2,
            'max_programs' => 2,
            'max_activities' => 2,
            'max_storages' => 2,
        ]);
        Membership::create([
            'name' => 'Pro',
            'price' => 20,
            'duration' => 30,
            'max_majors' => 3,
            'max_classes' => 3,
            'max_students' => 30,
            'max_partners' => 3,
            'max_mentors' => 3,
            'max_programs' => 3,
            'max_activities' => 3,
            'max_storages' => 3,
        ]);
        Membership::create([
            'name' => 'Development',
            'price' => 30000,
            'duration' => 48,
            'max_majors' => 10,
            'max_classes' => 50,
            'max_students' => 200,
            'max_partners' => 50,
            'max_mentors' => 50,
            'max_programs' => 50,
            'max_activities' => 300,
            'max_storages' => 0,
        ]);
    }
}
