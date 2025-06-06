<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') === 'local'){
            $school = School::where('name', 'SMK Development')->first();
            $userAdministrator = User::create([
                'name' => 'Administrator SMK Development',
                'email' => 'it@smkdev.ac.id',
                'phone' => '087890654378',
                'school_id' => $school->id,
                'username' => 'adminsmkdev',
                'email_verified_at' => now(),
                'password' => bcrypt('adminsmkdev'),
            ]);

            $userAdministrator->assignRole('School Administrator');

            $schoolMembership = $userAdministrator->school->membership;
            $schoolMembership->administrators_used += 1;
            $schoolMembership->save();

            // Select all id of major 
            $majors = $school->majors()->pluck('id')->toArray();

            $userMajorCoordinator = User::create([
                'name' => 'Koordinator Jurusan SMK Development',
                'email' => 'major@smkdev.ac.id',
                'phone' => '087890654377',
                'school_id' => $school->id,
                'major_id' => $majors[array_rand($majors)],
                'username' => 'majorcoordinator',
                'email_verified_at' => now(),
                'password' => bcrypt('majorcoordinator'),
            ]);

            $userMajorCoordinator->assignRole('Major Coordinator');
            $schoolMembership = $userMajorCoordinator->school->membership;
            $schoolMembership->coordinators_used += 1;
            $schoolMembership->save();

            $userTeacher = User::create([
                'name' => 'Teacher SMK Development',
                'email' => 'teacher@smkdev.ac.id',
                'phone' => '087890654376',
                'school_id' => $school->id,
                'username' => 'teachersmkdev',
                'email_verified_at' => now(),
                'password' => bcrypt('teachersmkdev'),
            ]);

            $userTeacher->assignRole('Teacher');
            $schoolMembership = $userTeacher->school->membership;
            $schoolMembership->teachers_used += 1;
            $schoolMembership->save();

            $userStudent = User::create([
                'name' => 'Student SMK Development',
                'email' => 'student@smkdev.ac.id',
                'phone' => '087890654375',
                'school_id' => $school->id,
                'username' => 'studentsmkdev',
                'email_verified_at' => now(),
                'password' => bcrypt('studentsmkdev'),
            ]);

            $userStudent->assignRole('Student');
            $schoolMembership = $userStudent->school->membership;
            $schoolMembership->students_used += 1;
            $schoolMembership->save();

            $userMentor = User::create([
                'name' => 'Mentor SMK Development',
                'email' => 'mentor@smkdev.ac.id',
                'phone' => '087890654374',
                'school_id' => $school->id,
                'username' => 'mentorsmkdev',
                'email_verified_at' => now(),
                'password' => bcrypt('mentorsmkdev'),
            ]);

            $userMentor->assignRole('Mentor');
            $schoolMembership = $userMentor->school->membership;
            $schoolMembership->mentors_used += 1;
            $schoolMembership->save();
        }else if (env('APP_ENV') === 'testing'){
            $school = School::where('name', 'SMK Testing')->first();
            $userAdministrator = User::create([
                'name' => 'Administrator SMK Testing',
                'email' => 'it@smktest.ac.id',
                'phone' => '087890614378',
                'school_id' => $school->id,
                'username' => 'adminsmktest',
                'email_verified_at' => now(),
                'password' => bcrypt('adminsmktest'),
            ]);
            $userAdministrator->assignRole('School Administrator');

            $schoolMembership = $userAdministrator->school->membership;
            $schoolMembership->administrators_used += 1;
            $schoolMembership->save();
        }else{
            $school = School::where('name', 'SMKN 1 Trenggalek')->first();
            $userAdministrator = User::create([
                'name' => 'Mariska Indrawati',
                'email' => 'mariska@smk1trenggalek.ac.id',
                'phone' => '087890654378',
                'school_id' => $school->id,
                'username' => 'mariska',
                'email_verified_at' => now(),
                'password' => bcrypt('mariska'),
            ]);
            $userAdministrator->assignRole('School Administrator');

            $schoolMembership = $userAdministrator->school->membership;
            $schoolMembership->administrators_used += 1;
            $schoolMembership->save();
        }
    }
}
