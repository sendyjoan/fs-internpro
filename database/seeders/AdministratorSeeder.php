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
