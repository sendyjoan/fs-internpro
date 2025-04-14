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
            'duration' => 1,
            'max_administrators' => 1,
            'max_coordinators' => 1,
            'max_teachers' => 1,
            'max_mentors' => 1,
            'max_students' => 10,
            'max_majors' => 1,
            'max_classes' => 1,
            'max_partners' => 1,
            'max_programs' => 1,
            'max_activities' => 1,
            'max_storages' => 1,
        ]);
        Membership::create([
            'name' => 'Basic',
            'price' => 10000,
            'duration' => 2,
            'max_administrators' => 2,
            'max_coordinators' => 2,
            'max_teachers' => 2,
            'max_mentors' => 2,
            'max_students' => 20,
            'max_majors' => 2,
            'max_classes' => 2,
            'max_partners' => 2,
            'max_programs' => 2,
            'max_activities' => 2,
            'max_storages' => 2,
        ]);
        Membership::create([
            'name' => 'Pro',
            'price' => 20000,
            'duration' => 3,
            'max_administrators' => 3,
            'max_coordinators' => 3,
            'max_teachers' => 3,
            'max_mentors' => 3,
            'max_students' => 30,
            'max_majors' => 3,
            'max_classes' => 3,
            'max_partners' => 3,
            'max_programs' => 3,
            'max_activities' => 3,
            'max_storages' => 3,
        ]);
        Membership::create([
            'name' => 'Development',
            'price' => 30000,
            'duration' => 48,
            'max_administrators' => 5,
            'max_coordinators' => 5,
            'max_teachers' => 5,
            'max_mentors' => 5,
            'max_students' => 50,
            'max_majors' => 5,
            'max_classes' => 5,
            'max_partners' => 5,
            'max_programs' => 5,
            'max_activities' => 5,
            'max_storages' => 5,
        ]);
    }
}
