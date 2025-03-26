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
        $membership = Membership::where('name', 'Free')->first();
        $smk1 = School::create([
            'name' => 'SMKN 1 Trenggalek',
            'email' => 'admin@smk1trenggalek.ac.id',
            'phone' => '081222333444',
            'address' => 'Trenggalek',
            'contact' => 'Bu Mariska',
            // 'membership_id' => $membership->id,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $summary = SchoolMembershipSummary::create([
            'school_id' => $smk1->id,
            'membership_id' => $membership->id,
            'start_membership' => now()->format('Y-m-d'),
            'end_membership' => now()->addMonth(1)->format('Y-m-d'),
        ]);
    }
}
