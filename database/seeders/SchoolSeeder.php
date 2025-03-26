<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolMembershipSummary;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('name', 'Administrator')->first();
        if (env('APP_ENV') === 'local'){
            $membership = Membership::where('name', 'Development')->first();
            $smkdev = School::create([
                'name' => 'SMK Development',
                'email' => 'admin@smkdev.ac.id',
                'phone' => '081234567890',
                'address' => 'Jl. Development No.9 Lowokwaru Kota Malang',
                'contact' => 'Tim Development',
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $summary = SchoolMembershipSummary::create([
                'school_id' => $smkdev->id,
                'membership_id' => $membership->id,
                'start_membership' => now()->format('Y-m-d'),
                'end_membership' => now()->addMonth($membership->duration)->format('Y-m-d'),
            ]);
        }
        if (env('APP_ENV') === 'testing'){
            $membership = Membership::where('name', 'Pro')->first();
            $smkdev = School::create([
                'name' => 'SMK Testing',
                'email' => 'admin@smktest.ac.id',
                'phone' => '081199987623',
                'address' => 'Jl. Testing No.5 Sukun Kabupaten Malang',
                'contact' => 'Tim Quality Assurance',
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $summary = SchoolMembershipSummary::create([
                'school_id' => $smkdev->id,
                'membership_id' => $membership->id,
                'start_membership' => now()->format('Y-m-d'),
                'end_membership' => now()->addMonth($membership->duration)->format('Y-m-d'),
            ]);
        }
        if (env('APP_ENV') === 'production') {
            $membership = Membership::where('name', 'Free')->first();
            $smk1 = School::create([
                'name' => 'SMKN 1 Trenggalek',
                'email' => 'admin@smk1trenggalek.ac.id',
                'phone' => '081222333444',
                'address' => 'Jl. Raya Trenggalek Surabaya No.3 Kabupaten Trenggalek',
                'contact' => 'Bu Mariska',
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            
            $summary = SchoolMembershipSummary::create([
                'school_id' => $smk1->id,
                'membership_id' => $membership->id,
                'start_membership' => now()->format('Y-m-d'),
                'end_membership' => now()->addMonth($membership->duration)->format('Y-m-d'),
            ]);
        }
    }
}
